<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php get_template_part('template-parts/header/header'); ?>

<header class="header">

    <div class="container">

        <div class="header__wrapper">

            <?php get_template_part('template-parts/header/logo'); ?>

            <?php get_template_part('template-parts/header/navigation'); ?>

            <?php get_template_part('template-parts/header/search'); ?>

            <?php get_template_part('template-parts/header/actions'); ?>

        </div>

    </div>

</header>