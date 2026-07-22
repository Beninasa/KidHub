<?php

defined('ABSPATH') || exit;

get_header();
?>

<main class="page">
    <div class="container">

        <?php while (have_posts()) : ?>
            <?php the_post(); ?>

            <article <?php post_class('page__content'); ?>>
                <h1 class="page__title">
                    <?php the_title(); ?>
                </h1>

                <?php
                // Для thank-you используем контролируемый шаблон WooCommerce.
                if (
                    function_exists('kidhub_is_order_received_page')
                    && kidhub_is_order_received_page()
                ) {
                    echo do_shortcode('[woocommerce_checkout]');
                } else {
                    the_content();

                    if (
                        function_exists('is_checkout')
                        && is_checkout()
                        && function_exists(
                            'kidhub_render_checkout_continue_shopping'
                        )
                    ) {
                        kidhub_render_checkout_continue_shopping();
                    }
                }
                ?>
            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();
