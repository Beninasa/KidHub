<?php

/**
 * KidHub order confirmation page.
 *
 * This template overrides WooCommerce's checkout/thankyou.php template.
 * Review it whenever WooCommerce bumps the original template version.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package KidHub\WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order|false $order
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order kidhub-order-confirmation">
    <?php if ($order) : ?>
        <?php do_action('woocommerce_before_thankyou', $order->get_id()); ?>

        <?php if ($order->has_status('failed')) : ?>
            <p
                class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"
            >
                <?php
                esc_html_e(
                    'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.',
                    'woocommerce'
                );
                ?>
            </p>

            <p
                class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions"
            >
                <a
                    href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
                    class="button pay"
                >
                    <?php esc_html_e('Pay', 'woocommerce'); ?>
                </a>

                <?php if (is_user_logged_in()) : ?>
                    <a
                        href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                        class="button pay"
                    >
                        <?php esc_html_e('My account', 'woocommerce'); ?>
                    </a>
                <?php endif; ?>
            </p>
        <?php else : ?>
            <section
                class="kidhub-order-confirmation__status"
                aria-labelledby="kidhub-order-confirmation-title"
            >
                <span
                    class="kidhub-order-confirmation__icon"
                    aria-hidden="true"
                >
                    ✓
                </span>

                <h1
                    id="kidhub-order-confirmation-title"
                    class="kidhub-order-confirmation__title"
                >
                    <?php esc_html_e('Дякуємо! Замовлення прийнято.', 'kidhub'); ?>
                </h1>

                <p class="kidhub-order-confirmation__message">
                    <?php
                    esc_html_e(
                        'Ми отримали ваше замовлення та вже готуємо його до обробки.',
                        'kidhub'
                    );
                    ?>
                </p>
            </section>
        <?php endif; ?>

        <?php
        do_action(
            'woocommerce_thankyou_' . $order->get_payment_method(),
            $order->get_id()
        );
        ?>

        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
    <?php else : ?>
        <?php
        wc_get_template(
            'checkout/order-received.php',
            ['order' => false]
        );
        ?>
    <?php endif; ?>
</div>
