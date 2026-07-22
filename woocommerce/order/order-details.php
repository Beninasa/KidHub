<?php

/**
 * KidHub order details.
 *
 * Adds the order number and date to the existing order table on the
 * order-received page. Other WooCommerce order views keep their standard
 * structure.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package KidHub\WooCommerce\Templates
 * @version 10.9.0
 *
 * @var bool $show_downloads Controls the downloads table output.
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id);

if (! $order) {
    return;
}

$order_items = $order->get_items(
    apply_filters('woocommerce_purchase_order_item_types', 'line_item')
);
$show_purchase_note = $order->has_status(
    apply_filters(
        'woocommerce_purchase_note_order_statuses',
        ['completed', 'processing']
    )
);
$downloads = $order->get_downloadable_items();
$actions = array_filter(
    wc_get_account_orders_actions($order),
    static function ($key) {
        return 'view' !== $key;
    },
    ARRAY_FILTER_USE_KEY
);

$show_customer_details = $order->get_user_id() === get_current_user_id();
$show_confirmation_meta = (
    function_exists('kidhub_is_order_received_page')
    && kidhub_is_order_received_page()
);
$date_created = $order->get_date_created();

if ($show_downloads) {
    wc_get_template(
        'order/order-downloads.php',
        [
            'downloads'  => $downloads,
            'show_title' => true,
        ]
    );
}
?>

<section class="woocommerce-order-details">
    <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

    <h2 class="woocommerce-order-details__title">
        <?php esc_html_e('Order details', 'woocommerce'); ?>
    </h2>

    <table
        class="woocommerce-table woocommerce-table--order-details shop_table order_details"
    >
        <thead>
            <?php if ($show_confirmation_meta) : ?>
                <tr class="kidhub-order-details__meta-row">
                    <th scope="row">
                        <?php esc_html_e('Номер замовлення:', 'kidhub'); ?>
                    </th>
                    <td>
                        <?php echo esc_html($order->get_order_number()); ?>
                    </td>
                </tr>

                <?php if ($date_created) : ?>
                    <tr class="kidhub-order-details__meta-row">
                        <th scope="row">
                            <?php esc_html_e('Дата:', 'kidhub'); ?>
                        </th>
                        <td>
                            <?php
                            echo esc_html(wc_format_datetime($date_created));
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <tr class="kidhub-order-details__columns">
                <th class="woocommerce-table__product-name product-name">
                    <?php esc_html_e('Product', 'woocommerce'); ?>
                </th>
                <th class="woocommerce-table__product-table product-total">
                    <?php esc_html_e('Total', 'woocommerce'); ?>
                </th>
            </tr>
        </thead>

        <tbody>
            <?php
            do_action(
                'woocommerce_order_details_before_order_table_items',
                $order
            );

            foreach ($order_items as $item_id => $item) {
                $product = $item->get_product();

                wc_get_template(
                    'order/order-details-item.php',
                    [
                        'order'              => $order,
                        'item_id'            => $item_id,
                        'item'               => $item,
                        'show_purchase_note' => $show_purchase_note,
                        'purchase_note'      => $product
                            ? $product->get_purchase_note()
                            : '',
                        'product'            => $product,
                    ]
                );
            }

            do_action(
                'woocommerce_order_details_after_order_table_items',
                $order
            );
            ?>
        </tbody>

        <tfoot>
            <?php foreach ($order->get_order_item_totals() as $total) : ?>
                <tr>
                    <th scope="row">
                        <?php echo esc_html($total['label']); ?>
                    </th>
                    <td><?php echo wp_kses_post($total['value']); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if ($order->get_customer_note()) : ?>
                <tr>
                    <th><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                    <td>
                        <?php
                        $customer_note = wc_wptexturize_order_note(
                            $order->get_customer_note()
                        );
                        echo wp_kses(nl2br($customer_note), ['br' => []]);
                        ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if (! empty($actions)) : ?>
                <tr>
                    <th class="order-actions--heading">
                        <?php esc_html_e('Actions', 'woocommerce'); ?>:
                    </th>
                    <td>
                        <?php
                        $wp_button_class = wc_wp_theme_get_element_class_name(
                            'button'
                        );
                        $wp_button_class = $wp_button_class
                            ? ' ' . $wp_button_class
                            : '';

                        foreach ($actions as $key => $action) {
                            $action_aria_label = ! empty(
                                $action['aria-label']
                            )
                                ? $action['aria-label']
                                : sprintf(
                                    /* translators: 1: action, 2: order number. */
                                    __(
                                        '%1$s order number %2$s',
                                        'woocommerce'
                                    ),
                                    $action['name'],
                                    $order->get_order_number()
                                );
                            ?>
                            <a
                                href="<?php echo esc_url($action['url']); ?>"
                                class="woocommerce-button<?php
                                echo esc_attr($wp_button_class);
                                ?> button <?php
                                echo esc_attr(sanitize_html_class($key));
                                ?> order-actions-button"
                                aria-label="<?php
                                echo esc_attr($action_aria_label);
                                ?>"
                            >
                                <?php echo esc_html($action['name']); ?>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tfoot>
    </table>

    <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
</section>

<?php
do_action('woocommerce_after_order_details', $order);

if ($show_customer_details) {
    wc_get_template('order/order-details-customer.php', ['order' => $order]);
}
