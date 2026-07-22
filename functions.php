<?php

/**
 * Подключение стилей темы KidHub
 */
function kidhub_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'kidhub_setup');

/**
 * Надёжная проверка страницы успешного оформления заказа.
 */
function kidhub_is_order_received_page()
{
    if (
        function_exists('is_order_received_page')
        && is_order_received_page()
    ) {
        return true;
    }

    if (
        function_exists('is_wc_endpoint_url')
        && is_wc_endpoint_url('order-received')
    ) {
        return true;
    }

    global $wp;

    return isset($wp->query_vars['order-received']);
}

function kidhub_enqueue_styles()
{
    wp_enqueue_style(
        'kidhub-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        [],
        '1.0'
    );

    wp_enqueue_style(
        'kidhub-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        ['kidhub-variables'],
        null
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

    wp_enqueue_style(
        'kidhub-promotion',
        get_template_directory_uri() . '/assets/css/promotion.css',
        ['kidhub-hero'],
        '1.0'
);

    wp_enqueue_style(
        'kidhub-catalog',
        get_template_directory_uri() . '/assets/css/catalog.css',
        ['kidhub-promotion'],
        '1.0'
);
if (function_exists('is_product') && is_product()) {
    wp_enqueue_style(
        'kidhub-product',
        get_template_directory_uri() . '/assets/css/product.css',
        ['kidhub-catalog'],
        '1.0'
    );
}

if (function_exists('is_cart') && is_cart()) {
    $cart_style_path = get_template_directory()
        . '/assets/css/cart.css';

    wp_enqueue_style(
        'kidhub-cart',
        get_template_directory_uri() . '/assets/css/cart.css',
        ['kidhub-catalog'],
        file_exists($cart_style_path)
            ? (string) filemtime($cart_style_path)
            : '1.0'
    );
}

$is_checkout_page = function_exists('is_checkout') && is_checkout();
$is_order_received = kidhub_is_order_received_page();

if ($is_checkout_page && ! $is_order_received) {
    $checkout_style_path = get_template_directory()
        . '/assets/css/checkout.css';

    wp_enqueue_style(
        'kidhub-checkout',
        get_template_directory_uri() . '/assets/css/checkout.css',
        ['kidhub-catalog'],
        file_exists($checkout_style_path)
            ? (string) filemtime($checkout_style_path)
            : '1.0'
    );
}

if ($is_checkout_page || $is_order_received) {
    $order_confirmation_style_path = get_template_directory()
        . '/assets/css/order-confirmation.css';

    wp_enqueue_style(
        'kidhub-order-confirmation',
        get_template_directory_uri()
            . '/assets/css/order-confirmation.css',
        ['kidhub-catalog'],
        file_exists($order_confirmation_style_path)
            ? (string) filemtime($order_confirmation_style_path)
            : '1.0'
    );
}

}

add_action('wp_enqueue_scripts', 'kidhub_enqueue_styles');

/**
 * Настройка вкладок страницы товара.
 */
function kidhub_customize_product_tabs($tabs)
{
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = __(
            'Характеристики',
            'kidhub'
        );
    }

    $tabs['delivery_payment'] = [
        'title'    => __('Доставка й оплата', 'kidhub'),
        'priority' => 25,
        'callback' => 'kidhub_render_delivery_payment_tab',
    ];

    return $tabs;
}

add_filter(
    'woocommerce_product_tabs',
    'kidhub_customize_product_tabs'
);

/**
 * Содержимое вкладки доставки и оплаты.
 */
function kidhub_render_delivery_payment_tab()
{
    get_template_part(
        'template-parts/components/product/product-delivery'
    );
}

add_filter(
    'woocommerce_product_additional_information_heading',
    '__return_false'
);

/**
 * Заголовок блока похожих товаров.
 */
function kidhub_related_products_heading()
{
    return __('Подібні товари', 'kidhub');
}

add_filter(
    'woocommerce_product_related_products_heading',
    'kidhub_related_products_heading'
);

function kidhub_replace_related_products()
{
    if (! function_exists('WC')) {
        return;
    }

    remove_action(
        'woocommerce_after_single_product_summary',
        'woocommerce_output_related_products',
        20
    );

    add_action(
        'woocommerce_after_single_product_summary',
        'kidhub_render_related_products',
        20
    );
}
add_action('wp', 'kidhub_replace_related_products');


function kidhub_render_related_products()
{
    global $product;

    if (
        ! is_product()
        || ! $product instanceof WC_Product
    ) {
        return;
    }

    $related_ids = wc_get_related_products(
        $product->get_id(),
        4,
        [$product->get_id()]
    );

    if (empty($related_ids)) {
        return;
    }

    get_template_part(
        'template-parts/components/product/product-related',
        null,
        [
            'product_ids' => $related_ids,
        ]
    );
}

/**
 * Ссылка на корзину со счётчиком товаров.
 */
function kidhub_render_cart_link()
{
    if (! function_exists('wc_get_cart_url')) {
        return;
    }

    $cart_count = (
        function_exists('WC')
        && WC()->cart
    )
        ? WC()->cart->get_cart_contents_count()
        : 0;

    $cart_label = sprintf(
        _n(
            '%d товар у кошику',
            '%d товарів у кошику',
            $cart_count,
            'kidhub'
        ),
        $cart_count
    );
    ?>

    <a
        href="<?php echo esc_url(wc_get_cart_url()); ?>"
        class="header-actions__cart"
        aria-label="<?php echo esc_attr($cart_label); ?>"
    >
        <span class="header-actions__cart-label">
            <?php esc_html_e('Кошик', 'kidhub'); ?>
        </span>

        <span
            class="header-actions__cart-count"
            aria-hidden="true"
        >
            <?php echo esc_html($cart_count); ?>
        </span>
    </a>

    <?php
}

/**
 * Обновление счётчика после AJAX-добавления товара.
 */
function kidhub_update_cart_fragments($fragments)
{
    ob_start();

    kidhub_render_cart_link();

    $fragments['a.header-actions__cart'] = ob_get_clean();

    return $fragments;
}

add_filter(
    'woocommerce_add_to_cart_fragments',
    'kidhub_update_cart_fragments'
);

/**
 * Ссылка на собственную страницу каталога KidHub.
 */
function kidhub_get_catalog_url()
{
    $catalog_page = get_page_by_path('catalog', OBJECT, 'page');
    $catalog_url = $catalog_page instanceof WP_Post
        ? get_permalink($catalog_page)
        : '';

    return $catalog_url ?: home_url('/catalog/');
}

/**
 * Ссылка для продолжения покупок под кнопкой оформления заказа.
 */
function kidhub_render_checkout_continue_shopping()
{
    ?>

    <a
        href="<?php echo esc_url(kidhub_get_catalog_url()); ?>"
        class="kidhub-checkout__continue-shopping"
    >
        <?php esc_html_e('Продовжити покупки', 'kidhub'); ?>
    </a>

    <?php
}

/**
 * Кнопка продолжения покупок после успешного оформления заказа.
 */
function kidhub_render_order_confirmation_actions($order_id)
{
    if (
        ! $order_id
        || ! function_exists('wc_get_order')
        || ! kidhub_is_order_received_page()
    ) {
        return;
    }

    $order = wc_get_order($order_id);

    if (! $order instanceof WC_Order || $order->has_status('failed')) {
        return;
    }
    ?>

    <p class="kidhub-order-confirmation__actions">
        <a
            href="<?php echo esc_url(kidhub_get_catalog_url()); ?>"
            class="kidhub-order-confirmation__button"
        >
            <?php esc_html_e('Повернутися до каталогу', 'kidhub'); ?>
        </a>
    </p>

    <?php
}

add_action(
    'woocommerce_thankyou',
    'kidhub_render_order_confirmation_actions',
    20,
    1
);

/**
 * Все стандартные ссылки WooCommerce «Вернуться в магазин» ведут в каталог.
 */
function kidhub_return_to_shop_redirect($url)
{
    return kidhub_get_catalog_url();
}

add_filter(
    'woocommerce_return_to_shop_redirect',
    'kidhub_return_to_shop_redirect'
);

/**
 * Ссылка «Перейти в магазин» в блочной пустой корзине.
 */
function kidhub_empty_cart_catalog_url($block_content)
{
    if (
        ! function_exists('is_cart')
        || ! is_cart()
        || ! function_exists('wc_get_page_permalink')
    ) {
        return $block_content;
    }

    $shop_url = wc_get_page_permalink('shop');

    if (! $shop_url) {
        return $block_content;
    }

    return str_replace(
        $shop_url,
        kidhub_get_catalog_url(),
        $block_content
    );
}

add_filter(
    'render_block_woocommerce/empty-cart-block',
    'kidhub_empty_cart_catalog_url'
);
