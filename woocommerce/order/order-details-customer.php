<?php

/**
 * KidHub customer delivery details.
 *
 * Shows one delivery card on the order confirmation page. The billing
 * address is used only as a fallback when WooCommerce has no separate
 * shipping address.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package KidHub\WooCommerce\Templates
 * @version 8.7.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;

$shipping_address = $order->get_formatted_shipping_address();
$delivery_address = $shipping_address
    ?: $order->get_formatted_billing_address(
        esc_html__('N/A', 'woocommerce')
    );
$phone = $order->get_shipping_phone() ?: $order->get_billing_phone();
$email = $order->get_billing_email();
$phone_href = $phone
    ? preg_replace('/[^0-9+]/', '', $phone)
    : '';
?>

<section
    class="woocommerce-customer-details kidhub-delivery-details"
    aria-labelledby="kidhub-delivery-details-title"
>
    <h2
        id="kidhub-delivery-details-title"
        class="woocommerce-column__title kidhub-delivery-details__title"
    >
        <?php esc_html_e('Адреса доставки', 'kidhub'); ?>
    </h2>

    <div class="kidhub-delivery-details__table">
        <div class="kidhub-delivery-details__row">
            <span class="kidhub-delivery-details__label">
                <?php esc_html_e('Адреса:', 'kidhub'); ?>
            </span>

            <address class="kidhub-delivery-details__value">
                <?php echo wp_kses_post($delivery_address); ?>
            </address>
        </div>

        <?php if ($phone) : ?>
            <div class="kidhub-delivery-details__row">
                <span class="kidhub-delivery-details__label">
                    <?php esc_html_e('Телефон:', 'kidhub'); ?>
                </span>

                <a
                    class="kidhub-delivery-details__value"
                    href="tel:<?php echo esc_attr($phone_href); ?>"
                >
                    <?php echo esc_html($phone); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($email) : ?>
            <div class="kidhub-delivery-details__row">
                <span class="kidhub-delivery-details__label">
                    <?php esc_html_e('Електронна пошта:', 'kidhub'); ?>
                </span>

                <a
                    class="kidhub-delivery-details__value"
                    href="mailto:<?php echo esc_attr($email); ?>"
                >
                    <?php echo esc_html($email); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php
    do_action(
        'woocommerce_order_details_after_customer_address',
        'shipping',
        $order
    );

    do_action('woocommerce_order_details_after_customer_details', $order);
    ?>
</section>
