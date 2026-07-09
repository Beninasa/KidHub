<article class="product-card">

    <a href="#" class="product-card__image">
        <span>Фото товару</span>
    </a>

    <div class="product-card__body">

        <?php if (!empty($args['badge'])) : ?>
            <span class="product-card__badge">
                <?php echo esc_html($args['badge']); ?>
            </span>
        <?php endif; ?>

        <h3 class="product-card__title">
            <a href="#"><?php echo esc_html($args['name']); ?></a>
        </h3>

        <div class="product-card__prices">
            <span class="product-card__price">
                <?php echo esc_html($args['price']); ?>
            </span>

            <?php if (!empty($args['old_price'])) : ?>
                <span class="product-card__old-price">
                    <?php echo esc_html($args['old_price']); ?>
                </span>
            <?php endif; ?>
        </div>

        <a href="#" class="button product-card__button">У кошик</a>

    </div>

</article>