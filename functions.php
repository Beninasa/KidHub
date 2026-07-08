<?php

/**
 * Подключение стилей темы KidHub
 */

function kidhub_enqueue_styles()
{
    wp_enqueue_style(
        'kidhub-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        [],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-base',
        get_template_directory_uri() . '/assets/css/base.css',
        ['kidhub-variables'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-layout',
        get_template_directory_uri() . '/assets/css/layout.css',
        ['kidhub-base'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-header',
        get_template_directory_uri() . '/assets/css/header.css',
        ['kidhub-layout'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        ['kidhub-header'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-buttons',
        get_template_directory_uri() . '/assets/css/buttons.css',
        ['kidhub-footer'],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-cards',
        get_template_directory_uri() . '/assets/css/cards.css',
        ['kidhub-buttons'],
        '1.0'
    );

   wp_enqueue_style(
    'kidhub-hero',
    get_template_directory_uri() . '/assets/css/hero.css',
    ['kidhub-cards'],
    '1.0'
);
}

add_action('wp_enqueue_scripts', 'kidhub_enqueue_styles');