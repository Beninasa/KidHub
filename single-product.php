<?php

defined('ABSPATH') || exit;

get_header();
?>

<main class="product-page">
    <div class="container">

        <?php woocommerce_breadcrumb(); ?>

        <?php while (have_posts()) : ?>
            <?php the_post(); ?>

            <?php
            get_template_part(
                'template-parts/components/product/product-main'
            );
            ?>
        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();