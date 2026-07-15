<?php

$products = require get_template_directory() . '/inc/catalog/products-data.php';
$sorting = isset($_GET['sorting'])
    ? sanitize_key(wp_unslash($_GET['sorting']))
    : 'popular';
switch ($sorting) {

    case 'price-asc':
        usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        break;

    case 'price-desc':
        usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        break;

    case 'rating':
        usort($products, fn($a, $b) => $b['rating'] <=> $a['rating']);
        break;

    case 'newest':
        usort($products, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
        break;

    default:
        usort($products, fn($a, $b) => $b['popularity'] <=> $a['popularity']);
        break;
}
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