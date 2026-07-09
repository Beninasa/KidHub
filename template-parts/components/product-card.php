<article class="product-card">

    <div class="product-card__image">
        <span>Фото</span>
    </div>

    <div class="product-card__body">

        <?php if (!empty($args['badge'])) : ?>
            <span class="product-card__badge">
                <?php echo esc_html($args['badge']); ?>
            </span>
        <?php endif; ?>

        <h3 class="product-card__title">
            <?php echo esc_html($args['name']); ?>
        </h3>

        <p class="product-card__price">
            <?php echo esc_html($args['price']); ?>
        </p>

        <a href="#" class="button product-card__button">Купити</a>

    </div>

</article>