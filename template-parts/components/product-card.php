<?php

$name      = $args['name'] ?? '';
$price     = $args['price'] ?? '';
$old_price = $args['old_price'] ?? '';
$badge     = $args['badge'] ?? '';
$image     = $args['image'] ?? '';
$rating    = $args['rating'] ?? '0';
$reviews   = $args['reviews'] ?? '0';
$sku       = $args['sku'] ?? '';

$image_url = get_template_directory_uri()
    . '/assets/images/products/'
    . $image;

$product_url = '#';

if ($sku && function_exists('wc_get_product_id_by_sku')) {
    $product_id = wc_get_product_id_by_sku($sku);

    if ($product_id) {
        $product_url = get_permalink($product_id);
    }
}

$has_product_link = $product_url !== '#';

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
        <img
            src="<?php echo esc_url($image_url); ?>"
            alt="<?php echo esc_attr($name); ?>"
            class="product-card__img"
        >
    </a>

    <div class="product-card__body">

        <div class="product-card__badge-slot">
            <?php if (! empty($badge)) : ?>
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
            class="product-card__rating"
            aria-label="Рейтинг <?php echo esc_attr($rating); ?> з 5"
        >
            <span class="product-card__star">★</span>

            <span class="product-card__rating-value">
                <?php echo esc_html($rating); ?>
            </span>

            <span class="product-card__reviews">
                (<?php echo esc_html($reviews); ?>)
            </span>
        </div>

        <div class="product-card__prices">

            <span class="product-card__price">
                <?php echo esc_html($price) . ' грн'; ?>
            </span>

            <?php if (! empty($old_price)) : ?>
                <span class="product-card__old-price">
                    <?php echo esc_html($old_price) . ' грн'; ?>
                </span>
            <?php endif; ?>

        </div>

        <a
            href="<?php echo esc_url($product_url); ?>"
            class="button product-card__button"
        >
            Купити
        </a>

    </div>

</article>