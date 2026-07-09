<section class="popular-products">
    <div class="container">

        <div class="section-heading">
            <h2 class="section-heading__title">Популярні товари</h2>
            <p class="section-heading__text">Товари, які найчастіше переглядають покупці.</p>
        </div>

        <div class="products-grid">

            <?php
            $products = [
    ['name' => 'Дитячий плед', 'price' => '799 грн', 'old_price' => '999 грн', 'badge' => 'Хіт'],
    ['name' => 'М’яка іграшка', 'price' => '499 грн', 'old_price' => '649 грн', 'badge' => 'Акція'],
    ['name' => 'Боді для малюка', 'price' => '349 грн', 'old_price' => '', 'badge' => 'Новинка'],
    ['name' => 'Прорізувач', 'price' => '199 грн', 'old_price' => '', 'badge' => ''],
    ['name' => 'Дитячі шкарпетки', 'price' => '149 грн', 'old_price' => '', 'badge' => ''],
    ['name' => 'Коробка для речей', 'price' => '599 грн', 'old_price' => '749 грн', 'badge' => ''],
    ['name' => 'Подарунковий набір', 'price' => '1299 грн', 'old_price' => '1599 грн', 'badge' => 'Хіт'],
    ['name' => 'Розвиваюча іграшка', 'price' => '699 грн', 'old_price' => '', 'badge' => ''],
];

            foreach ($products as $product) {
                get_template_part(
                    'template-parts/components/product-card',
                    null,
                    $product
                );
            }
            ?>

        </div>

    </div>
</section>