<?php

defined('ABSPATH') || exit;

$product = $args['product'] ?? null;

if (! $product instanceof WC_Product) {
    return;
}

$category_names = wp_get_post_terms(
    $product->get_id(),
    'product_cat',
    [
        'fields' => 'names',
    ]
);

if (is_wp_error($category_names)) {
    $category_names = [];
}

$brand_names = [];

if (taxonomy_exists('product_brand')) {
    $brand_names = wp_get_post_terms(
        $product->get_id(),
        'product_brand',
        [
            'fields' => 'names',
        ]
    );

    if (is_wp_error($brand_names)) {
        $brand_names = [];
    }
}
?>

<div class="product-detail__meta product_meta">

    <?php if ($product->get_sku()) : ?>
        <span class="product-detail__meta-item">
            <strong>Артикул:</strong>
            <?php echo esc_html($product->get_sku()); ?>
        </span>
    <?php endif; ?>

    <?php if ($category_names) : ?>
        <span class="product-detail__meta-item">
            <strong>Категорія:</strong>
            <?php echo esc_html(implode(', ', $category_names)); ?>
        </span>
    <?php endif; ?>

    <?php if ($brand_names) : ?>
        <span class="product-detail__meta-item">
            <strong>Бренд:</strong>
            <?php echo esc_html(implode(', ', $brand_names)); ?>
        </span>
    <?php endif; ?>

</div>