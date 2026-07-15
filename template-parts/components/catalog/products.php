<?php

$products = $args['products'] ?? [];

?>

<?php if (empty($products)) : ?>

    <p class="catalog-products__empty">
        Товарів за вибраними параметрами не знайдено.
    </p>

<?php else : ?>

    <div class="products-grid">

        <?php foreach ($products as $product) : ?>

            <?php
            get_template_part(
                'template-parts/components/product-card',
                null,
                $product
            );
            ?>

        <?php endforeach; ?>

    </div>

<?php endif; ?>