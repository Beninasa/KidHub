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

                <?php the_content(); ?>
            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php
get_footer();