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
    [
        'name'      => 'Дитяча ковдра',
        'price'     => '899 грн',
        'old_price' => '',
        'badge'     => '',
        'image'     => 'blanket.jpg',
        'rating'    => '4.8',
        'reviews'   => '39',
    ],
    [
        'name'      => 'Пустушка',
        'price'     => '159 грн',
        'old_price' => '',
        'badge'     => '',
        'image'     => 'teether.jpg',
        'rating'    => '4.5',
        'reviews'   => '26',
    ],
    [
        'name'      => 'Дитячий комбінезон',
        'price'     => '1099 грн',
        'old_price' => '',
        'badge'     => 'Новинка',
        'image'     => 'bodysuit.jpg',
        'rating'    => '4.9',
        'reviews'   => '61',
    ],
    [
        'name'      => 'Ігровий килимок',
        'price'     => '1199 грн',
        'old_price' => '',
        'badge'     => '',
        'image'     => 'educational-toy.jpg',
        'rating'    => '4.8',
        'reviews'   => '48',
    ],
];

?>

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