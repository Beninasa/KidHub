<?php

defined('ABSPATH') || exit;

$products = require get_template_directory()
    . '/inc/catalog/products-data.php';

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

$price_min = isset($_GET['price_min'])
    ? max(0, (int) wp_unslash($_GET['price_min']))
    : 0;

$price_max = isset($_GET['price_max'])
    ? max(0, (int) wp_unslash($_GET['price_max']))
    : 0;

$categories = isset($_GET['category'])
    ? array_map('sanitize_key', (array) wp_unslash($_GET['category']))
    : [];

$brands = isset($_GET['brand'])
    ? array_map('sanitize_key', (array) wp_unslash($_GET['brand']))
    : [];

$ages = isset($_GET['age'])
    ? array_map('sanitize_key', (array) wp_unslash($_GET['age']))
    : [];

$products = array_filter(
    $products,
    function ($product) use (
        $categories,
        $brands,
        $ages,
        $price_min,
        $price_max
    ) {
        if (
            ! empty($categories) &&
            ! in_array($product['category'], $categories, true)
        ) {
            return false;
        }

        if (
            ! empty($brands) &&
            ! in_array($product['brand'], $brands, true)
        ) {
            return false;
        }

        if (
            ! empty($ages) &&
            ! in_array($product['age'], $ages, true)
        ) {
            return false;
        }

        if ($price_min > 0 && $product['price'] < $price_min) {
            return false;
        }

        if ($price_max > 0 && $product['price'] > $price_max) {
            return false;
        }

        return true;
    }
);

switch ($sorting) {
    case 'price-asc':
        usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        break;

    case 'price-desc':
        usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        break;

    case 'rating':
        usort($products, fn($a, $b) => $b['rating'] <=> $a['rating']);
        break;

    case 'newest':
        usort(
            $products,
            fn($a, $b) => strcmp($b['created_at'], $a['created_at'])
        );
        break;

    default:
        usort(
            $products,
            fn($a, $b) => $b['popularity'] <=> $a['popularity']
        );
        break;
}

$products_per_page = 8;

$total_products = count($products);

$total_pages = max(
    1,
    (int) ceil($total_products / $products_per_page)
);

$current_page = isset($_GET['catalog_page'])
    ? max(1, absint(wp_unslash($_GET['catalog_page'])))
    : 1;

$current_page = min($current_page, $total_pages);

$offset = ($current_page - 1) * $products_per_page;

$visible_products = array_slice(
    $products,
    $offset,
    $products_per_page
);

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

return [
    'products'       => $visible_products,
    'total_products' => $total_products,
    'total_pages'    => $total_pages,
    'current_page'   => $current_page,
    'query_args'     => $query_args,
];