<section class="popular-products">
    <div class="container">

        <div class="section-heading">
            <h2 class="section-heading__title">Популярні товари</h2>
            <p class="section-heading__text">Товари, які найчастіше переглядають покупці.</p>
        </div>

        <div class="products-grid">

            <?php
            $products = [
    [
        'name'      => 'Дитячий плед',
        'price'     => '799 грн',
        'old_price' => '999 грн',
        'badge'     => 'Хіт',
        'image'     => 'blanket.jpg',
        'rating'    => '4.9',
        'reviews'   => '124',
    ],
    [
        'name'      => 'М’яка іграшка',
        'price'     => '499 грн',
        'old_price' => '649 грн',
        'badge'     => 'Акція',
        'image'     => 'toy.jpg',
        'rating'    => '4.8',
        'reviews'   => '86',
    ],
    [
        'name'      => 'Боді для малюка',
        'price'     => '349 грн',
        'old_price' => '',
        'badge'     => 'Новинка',
        'image'     => 'bodysuit.jpg',
        'rating'    => '4.7',
        'reviews'   => '42',
    ],
    [
        'name'      => 'Прорізувач',
        'price'     => '199 грн',
        'old_price' => '',
        'badge'     => '',
        'image'     => 'teether.jpg',
        'rating'    => '4.9',
        'reviews'   => '68',
    ],
    [
        'name'      => 'Дитячі шкарпетки',
        'price'     => '149 грн',
        'old_price' => '',
        'badge'     => '',
        'image'     => 'socks.jpg',
        'rating'    => '4.6',
        'reviews'   => '31',
    ],
    [
        'name'      => 'Коробка для речей',
        'price'     => '599 грн',
        'old_price' => '749 грн',
        'badge'     => '',
        'image'     => 'storage-box.jpg',
        'rating'    => '4.8',
        'reviews'   => '54',
    ],
    [
        'name'      => 'Подарунковий набір',
        'price'     => '1299 грн',
        'old_price' => '1599 грн',
        'badge'     => 'Хіт',
        'image'     => 'gift-set.jpg',
        'rating'    => '5.0',
        'reviews'   => '97',
    ],
    [
        'name'      => 'Розвиваюча іграшка',
        'price'     => '699 грн',
        'old_price' => '',
        'badge'     => '',
        'image'     => 'educational-toy.jpg',
        'rating'    => '4.7',
        'reviews'   => '73',
    ],
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