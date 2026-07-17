<?php

defined('ABSPATH') || exit;

global $product;

if (! $product instanceof WC_Product) {
    $product = wc_get_product(get_the_ID());
}

if (! $product instanceof WC_Product) {
    return;
}

remove_action(
    'woocommerce_single_product_summary',
    'woocommerce_template_single_meta',
    40
);

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();

    return;
}
?>

<div
    id="product-<?php the_ID(); ?>"
    <?php wc_product_class('product-detail', $product); ?>
>
    <div class="product-detail__main">

        <div class="product-detail__gallery">
            <?php
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <div class="product-detail__summary summary entry-summary">
            <?php
            do_action('woocommerce_single_product_summary');
            get_template_part(
                'template-parts/components/product/product-meta',
                null,
                [
                    'product' => $product,
                ]
            );
            ?>
        </div>

    </div>

    <div class="product-detail__details">
        <?php
        do_action('woocommerce_after_single_product_summary');
        ?>
    </div>
</div>

<?php
do_action('woocommerce_after_single_product');