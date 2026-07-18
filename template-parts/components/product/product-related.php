<?php

$product_ids = $args['product_ids'] ?? [];

if (
    empty($product_ids)
    || ! function_exists('wc_get_product')
) {
    return;
}

$heading = apply_filters(
    'woocommerce_product_related_products_heading',
    __('Подібні товари', 'kidhub')
);

?>

<section class="product-related" aria-labelledby="product-related-title">
    <?php if ($heading) : ?>
        <h2
            class="product-related__title"
            id="product-related-title"
        >
            <?php echo esc_html($heading); ?>
        </h2>
    <?php endif; ?>

    <div class="products-grid product-related__grid">
        <?php foreach ($product_ids as $product_id) : ?>
            <?php
            $related_product = wc_get_product($product_id);

            if (
                ! $related_product instanceof WC_Product
                || ! $related_product->is_visible()
            ) {
                continue;
            }

            get_template_part(
                'template-parts/components/product-card',
                null,
                [   'product_id' => $related_product->get_id(),
                    'name'        => $related_product->get_name(),
                    'price_html'  => $related_product->get_price_html(),
                    'image_html'  => $related_product->get_image(
                        'woocommerce_thumbnail',
                        [
                            'class'   => 'product-card__img',
                            'loading' => 'lazy',
                        ]
                    ),
                    'rating'      => $related_product->get_average_rating(),
                    'reviews'     => $related_product->get_review_count(),
                    'sku'         => $related_product->get_sku(),
                    'product_url' => $related_product->get_permalink(),
                    'badge'       => $related_product->is_on_sale()
                        ? __('Акція', 'kidhub')
                        : '',
                ]
            );
            ?>
        <?php endforeach; ?>
    </div>
</section>