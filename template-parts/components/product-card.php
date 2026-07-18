<?php

$name         = $args['name'] ?? '';
$price        = $args['price'] ?? '';
$price_html   = $args['price_html'] ?? '';
$old_price    = $args['old_price'] ?? '';
$badge        = $args['badge'] ?? '';
$image        = $args['image'] ?? '';
$image_html   = $args['image_html'] ?? '';
$rating       = $args['rating'] ?? '';
$reviews      = $args['reviews'] ?? '0';
$sku          = $args['sku'] ?? '';
$product_url  = $args['product_url'] ?? '#';
$product_id = isset($args['product_id'])
    ? absint($args['product_id'])
    : 0;

$image_url = '';

if (! $image_html && $image) {
    $image_url = get_template_directory_uri()
        . '/assets/images/products/'
        . $image;
}

$card_product = null;

if ($product_id && function_exists('wc_get_product')) {
    $card_product = wc_get_product($product_id);
}

if (
    ! $card_product instanceof WC_Product &&
    $sku &&
    function_exists('wc_get_product_id_by_sku')
) {
    $product_id = wc_get_product_id_by_sku($sku);

    if ($product_id) {
        $card_product = wc_get_product($product_id);
    }
}

if ($card_product instanceof WC_Product) {
    $product_url = $card_product->get_permalink();
}

$has_product_link = $product_url !== '#';
$has_rating       = $rating !== '' && (float) $rating > 0;

$can_add_to_cart = (
    $card_product instanceof WC_Product &&
    $card_product->is_type('simple') &&
    $card_product->is_purchasable() &&
    $card_product->is_in_stock()
);

$button_url = $can_add_to_cart
    ? $card_product->add_to_cart_url()
    : $product_url;

$button_classes = 'button product-card__button';

if ($can_add_to_cart) {
    $button_classes .=
        ' product_type_simple add_to_cart_button ajax_add_to_cart';
}

$product_id = isset($args['product_id'])
    ? absint($args['product_id'])
    : 0;

?>

<article
    class="product-card<?php echo $has_product_link
        ? ' product-card--linked'
        : ''; ?>"
>

    <button
        type="button"
        class="product-card__favorite"
        aria-label="Додати <?php echo esc_attr($name); ?> до обраного"
    >
        <svg
            width="22"
            height="22"
            viewBox="0 0 24 24"
            aria-hidden="true"
        >
            <path
                d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21.3l7.8-7.8 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"
            />
        </svg>
    </button>

    <a
        href="<?php echo esc_url($product_url); ?>"
        class="product-card__image"
    >
        <?php if ($image_html) : ?>

            <?php echo wp_kses_post($image_html); ?>

        <?php elseif ($image_url) : ?>

            <img
                src="<?php echo esc_url($image_url); ?>"
                alt="<?php echo esc_attr($name); ?>"
                class="product-card__img"
            >

        <?php endif; ?>
    </a>

    <div class="product-card__body">

        <div class="product-card__badge-slot">
            <?php if ($badge) : ?>
                <span class="product-card__badge">
                    <?php echo esc_html($badge); ?>
                </span>
            <?php endif; ?>
        </div>

        <h3 class="product-card__title">
            <a href="<?php echo esc_url($product_url); ?>">
                <?php echo esc_html($name); ?>
            </a>
        </h3>

        <div
            class="product-card__rating<?php echo $has_rating
                ? ''
                : ' product-card__rating--empty'; ?>"
            <?php if ($has_rating) : ?>
                aria-label="Рейтинг <?php echo esc_attr($rating); ?> з 5"
            <?php else : ?>
                aria-hidden="true"
            <?php endif; ?>
        >
            <?php if ($has_rating) : ?>

                <span class="product-card__star">★</span>

                <span class="product-card__rating-value">
                    <?php echo esc_html($rating); ?>
                </span>

                <span class="product-card__reviews">
                    (<?php echo esc_html($reviews); ?>)
                </span>

            <?php endif; ?>
        </div>

        <div class="product-card__prices">

            <?php if ($price_html) : ?>

                <span class="product-card__price">
                    <?php echo wp_kses_post($price_html); ?>
                </span>

            <?php else : ?>

                <span class="product-card__price">
                    <?php echo esc_html($price) . ' грн'; ?>
                </span>

                <?php if ($old_price) : ?>
                    <span class="product-card__old-price">
                        <?php echo esc_html($old_price) . ' грн'; ?>
                    </span>
                <?php endif; ?>

            <?php endif; ?>

        </div>

            <a
                href="<?php echo esc_url($button_url); ?>"
                class="<?php echo esc_attr($button_classes); ?>"
                <?php if ($can_add_to_cart) : ?>
                    data-quantity="1"
                    data-product_id="<?php echo esc_attr($product_id); ?>"
                    data-product_sku="<?php echo esc_attr(
                        $card_product->get_sku()
                    ); ?>"
                    aria-label="<?php echo esc_attr(
                        sprintf(
                            __('Додати «%s» до кошика', 'kidhub'),
                            $card_product->get_name()
                        )
                    ); ?>"
                    rel="nofollow"
                <?php endif; ?>
            >
                <?php esc_html_e('Купити', 'kidhub'); ?>
            </a>

    </div>

</article>