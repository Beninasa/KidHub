<?php

/**
 * Подключение стилей темы KidHub
 */
function kidhub_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'kidhub_setup');

function kidhub_enqueue_styles()
{
    wp_enqueue_style(
        'kidhub-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        [],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        ['kidhub-variables'],
        null
    );

    wp_enqueue_style(
        'kidhub-base',
        get_template_directory_uri() . '/assets/css/base.css',
        ['kidhub-variables'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-layout',
        get_template_directory_uri() . '/assets/css/layout.css',
        ['kidhub-base'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-header',
        get_template_directory_uri() . '/assets/css/header.css',
        ['kidhub-layout'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        ['kidhub-header'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-buttons',
        get_template_directory_uri() . '/assets/css/buttons.css',
        ['kidhub-footer'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-cards',
        get_template_directory_uri() . '/assets/css/cards.css',
        ['kidhub-buttons'],
        '1.0'
    );

   wp_enqueue_style(
    'kidhub-hero',
    get_template_directory_uri() . '/assets/css/hero.css',
    ['kidhub-cards'],
    '1.0'
);

    wp_enqueue_style(
        'kidhub-promotion',
        get_template_directory_uri() . '/assets/css/promotion.css',
        ['kidhub-hero'],
        '1.0'
);

wp_enqueue_style(
    'kidhub-catalog',
    get_template_directory_uri() . '/assets/css/catalog.css',
    ['kidhub-promotion'],
    '1.0'
);
if (function_exists('is_product') && is_product()) {
    wp_enqueue_style(
        'kidhub-product',
        get_template_directory_uri() . '/assets/css/product.css',
        ['kidhub-catalog'],
        '1.0'
    );
}

if (function_exists('is_cart') && is_cart()) {
    wp_enqueue_style(
        'kidhub-cart',
        get_template_directory_uri() . '/assets/css/cart.css',
        ['kidhub-catalog'],
        '1.0'
    );
}

}

add_action('wp_enqueue_scripts', 'kidhub_enqueue_styles');

/**
 * Настройка вкладок страницы товара.
 */
function kidhub_customize_product_tabs($tabs)
{
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = __(
            'Характеристики',
            'kidhub'
        );
    }

    $tabs['delivery_payment'] = [
        'title'    => __('Доставка й оплата', 'kidhub'),
        'priority' => 25,
        'callback' => 'kidhub_render_delivery_payment_tab',
    ];

    return $tabs;
}

add_filter(
    'woocommerce_product_tabs',
    'kidhub_customize_product_tabs'
);

/**
 * Содержимое вкладки доставки и оплаты.
 */
function kidhub_render_delivery_payment_tab()
{
    get_template_part(
        'template-parts/components/product/product-delivery'
    );
}

add_filter(
    'woocommerce_product_additional_information_heading',
    '__return_false'
);

/**
 * Заголовок блока похожих товаров.
 */
function kidhub_related_products_heading()
{
    return __('Подібні товари', 'kidhub');
}

add_filter(
    'woocommerce_product_related_products_heading',
    'kidhub_related_products_heading'
);

function kidhub_replace_related_products()
{
    if (! function_exists('WC')) {
        return;
    }

    remove_action(
        'woocommerce_after_single_product_summary',
        'woocommerce_output_related_products',
        20
    );

    add_action(
        'woocommerce_after_single_product_summary',
        'kidhub_render_related_products',
        20
    );
}
add_action('wp', 'kidhub_replace_related_products');


function kidhub_render_related_products()
{
    global $product;

    if (
        ! is_product()
        || ! $product instanceof WC_Product
    ) {
        return;
    }

    $related_ids = wc_get_related_products(
        $product->get_id(),
        4,
        [$product->get_id()]
    );

    if (empty($related_ids)) {
        return;
    }

    get_template_part(
        'template-parts/components/product/product-related',
        null,
        [
            'product_ids' => $related_ids,
        ]
    );
}

/**
 * Ссылка на корзину со счётчиком товаров.
 */
function kidhub_render_cart_link()
{
    if (! function_exists('wc_get_cart_url')) {
        return;
    }

    $cart_count = (
        function_exists('WC')
        && WC()->cart
    )
        ? WC()->cart->get_cart_contents_count()
        : 0;

    $cart_label = sprintf(
        _n(
            '%d товар у кошику',
            '%d товарів у кошику',
            $cart_count,
            'kidhub'
        ),
        $cart_count
    );
    ?>

    <a
        href="<?php echo esc_url(wc_get_cart_url()); ?>"
        class="header-actions__cart"
        aria-label="<?php echo esc_attr($cart_label); ?>"
    >
        <span class="header-actions__cart-label">
            <?php esc_html_e('Кошик', 'kidhub'); ?>
        </span>

        <span
            class="header-actions__cart-count"
            aria-hidden="true"
        >
            <?php echo esc_html($cart_count); ?>
        </span>
    </a>

    <?php
}

/**
 * Обновление счётчика после AJAX-добавления товара.
 */
function kidhub_update_cart_fragments($fragments)
{
    ob_start();

    kidhub_render_cart_link();

    $fragments['a.header-actions__cart'] = ob_get_clean();

    return $fragments;
}

add_filter(
    'woocommerce_add_to_cart_fragments',
    'kidhub_update_cart_fragments'
);