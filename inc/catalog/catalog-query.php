<?php

defined('ABSPATH') || exit;

$sorting = isset($_GET['sorting'])
    ? sanitize_key(wp_unslash($_GET['sorting']))
    : 'popular';

$allowed_sorting = [
    'popular',
    'price-asc',
    'price-desc',
    'rating',
    'newest',
];

if (! in_array($sorting, $allowed_sorting, true)) {
    $sorting = 'popular';
}

/*
 * Параметры фильтров пока сохраняем в URL и пагинации.
 * К реальным категориям и атрибутам WooCommerce подключим их
 * на следующем этапе.
 */

$price_min = isset($_GET['price_min'])
    ? max(0, (int) wp_unslash($_GET['price_min']))
    : 0;

$price_max = isset($_GET['price_max'])
    ? max(0, (int) wp_unslash($_GET['price_max']))
    : 0;

$categories = isset($_GET['category'])
    ? array_map(
        'sanitize_title',
        (array) wp_unslash($_GET['category'])
    )
    : [];

$brands = isset($_GET['brand'])
    ? array_map(
        'sanitize_key',
        (array) wp_unslash($_GET['brand'])
    )
    : [];

$ages = isset($_GET['age'])
    ? array_map(
        'sanitize_key',
        (array) wp_unslash($_GET['age'])
    )
    : [];

$query_args = [
    'sorting' => $sorting,
];

if ($price_min > 0) {
    $query_args['price_min'] = $price_min;
}

if ($price_max > 0) {
    $query_args['price_max'] = $price_max;
}

if (! empty($categories)) {
    $query_args['category'] = $categories;
}

if (! empty($brands)) {
    $query_args['brand'] = $brands;
}

if (! empty($ages)) {
    $query_args['age'] = $ages;
}

/*
 * Если WooCommerce отключён, возвращаем пустой каталог
 * и не допускаем PHP-ошибку.
 */

if (
    ! function_exists('WC')
    || ! function_exists('wc_get_product')
    || ! is_object(WC()->query)
) {
    return [
        'products'       => [],
        'total_products' => 0,
        'total_pages'    => 1,
        'current_page'   => 1,
        'query_args'     => $query_args,
    ];
}

$sorting_config = [
    'popular' => [
        'orderby' => 'popularity',
        'order'   => 'DESC',
    ],
    'price-asc' => [
        'orderby' => 'price',
        'order'   => 'ASC',
    ],
    'price-desc' => [
        'orderby' => 'price',
        'order'   => 'DESC',
    ],
    'rating' => [
        'orderby' => 'rating',
        'order'   => 'DESC',
    ],
    'newest' => [
        'orderby' => 'date',
        'order'   => 'DESC',
    ],
];

$products_per_page = 8;

$requested_page = isset($_GET['catalog_page'])
    ? max(1, absint(wp_unslash($_GET['catalog_page'])))
    : 1;

/*
 * Выполняем товарный запрос с системными правилами
 * сортировки и видимости WooCommerce.
 */

$run_product_query = static function ($page) use (
    $sorting_config,
    $sorting,
    $products_per_page
) {
    $woocommerce_query = WC()->query;
    $sort               = $sorting_config[$sorting];

    $ordering_args = $woocommerce_query->get_catalog_ordering_args(
        $sort['orderby'],
        $sort['order']
    );

    $wp_query_args = [
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'posts_per_page'      => $products_per_page,
        'paged'               => $page,
        'fields'              => 'ids',
        'ignore_sticky_posts' => true,
        'orderby'             => $ordering_args['orderby'],
        'order'               => $ordering_args['order'],
        'tax_query'           => $woocommerce_query->get_tax_query(
            [],
            false
        ),
        'meta_query'          => $woocommerce_query->get_meta_query(
            [],
            false
        ),
    ];

    if (! empty($ordering_args['meta_key'])) {
        $wp_query_args['meta_key'] = $ordering_args['meta_key'];
    }

    $product_query = new WP_Query($wp_query_args);

    /*
     * WooCommerce добавляет временные SQL-фильтры
     * для сортировки. После запроса их нужно удалить.
     */
    $woocommerce_query->remove_ordering_args();

    return $product_query;
};

$run_product_query = static function ($page) use (
    $sorting_config,
    $sorting,
    $products_per_page,
    $price_min,
    $price_max,
    $categories,
    $brands,
    $ages
) {
    $woocommerce_query = WC()->query;
    $sort               = $sorting_config[$sorting];

    $ordering_args = $woocommerce_query->get_catalog_ordering_args(
        $sort['orderby'],
        $sort['order']
    );

    /*
     * Категории и глобальные атрибуты WooCommerce.
     */

    $tax_query = [];

    if (! empty($categories)) {
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $categories,
            'operator' => 'IN',
        ];
    }

    if (! empty($brands) && taxonomy_exists('pa_brand')) {
        $tax_query[] = [
            'taxonomy' => 'pa_brand',
            'field'    => 'slug',
            'terms'    => $brands,
            'operator' => 'IN',
        ];
    }

    if (! empty($ages) && taxonomy_exists('pa_age')) {
        $tax_query[] = [
            'taxonomy' => 'pa_age',
            'field'    => 'slug',
            'terms'    => $ages,
            'operator' => 'IN',
        ];
    }

    $tax_query = $woocommerce_query->get_tax_query(
        $tax_query,
        false
    );

    /*
     * Фильтр по актуальной цене товара.
     */

    $meta_query = [];

    if ($price_min > 0 && $price_max > 0) {
        $meta_query[] = [
            'key'     => '_price',
            'value'   => [$price_min, $price_max],
            'compare' => 'BETWEEN',
            'type'    => 'DECIMAL',
        ];
    } elseif ($price_min > 0) {
        $meta_query[] = [
            'key'     => '_price',
            'value'   => $price_min,
            'compare' => '>=',
            'type'    => 'DECIMAL',
        ];
    } elseif ($price_max > 0) {
        $meta_query[] = [
            'key'     => '_price',
            'value'   => $price_max,
            'compare' => '<=',
            'type'    => 'DECIMAL',
        ];
    }

    $meta_query = $woocommerce_query->get_meta_query(
        $meta_query,
        false
    );

    $wp_query_args = [
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'posts_per_page'      => $products_per_page,
        'paged'               => $page,
        'fields'              => 'ids',
        'ignore_sticky_posts' => true,
        'orderby'             => $ordering_args['orderby'],
        'order'               => $ordering_args['order'],
        'tax_query'           => $tax_query,
        'meta_query'          => $meta_query,
    ];

    if (! empty($ordering_args['meta_key'])) {
        $wp_query_args['meta_key'] = $ordering_args['meta_key'];
    }

    $product_query = new WP_Query($wp_query_args);

    $woocommerce_query->remove_ordering_args();

    return $product_query;
};

$product_query = $run_product_query($requested_page);

$total_products = (int) $product_query->found_posts;
$total_pages    = max(1, (int) $product_query->max_num_pages);
$current_page   = min($requested_page, $total_pages);

/*
 * Если запрошенной страницы больше не существует,
 * показываем последнюю доступную.
 */

$visible_products = [];

foreach ($product_query->posts as $product_id) {
    $product = wc_get_product($product_id);

    if (
        ! $product instanceof WC_Product
        || ! $product->is_visible()
    ) {
        continue;
    }

    $badge = '';

    if ($product->is_on_sale()) {
        $badge = __('Акція', 'kidhub');
    } elseif ($product->is_featured()) {
        $badge = __('Хіт', 'kidhub');
    }

    $visible_products[] = [
        'product_id'  => $product->get_id(),
        'name'        => $product->get_name(),
        'price_html'  => $product->get_price_html(),
        'image_html'  => $product->get_image(
            'woocommerce_thumbnail',
            [
                'class'   => 'product-card__img',
                'loading' => 'lazy',
            ]
        ),
        'rating'      => $product->get_average_rating(),
        'reviews'     => $product->get_review_count(),
        'sku'         => $product->get_sku(),
        'product_url' => $product->get_permalink(),
        'badge'       => $badge,
    ];
}

return [
    'products'       => $visible_products,
    'total_products' => $total_products,
    'total_pages'    => $total_pages,
    'current_page'   => $current_page,
    'query_args'     => $query_args,
];

