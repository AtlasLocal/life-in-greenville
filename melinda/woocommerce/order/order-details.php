<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order = wc_get_order( $order_id );

$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();

?>

<div class="row">

	<div class="col-sm-6">
		<div class="wc-account-order-card">
			<h2 class="wc-account-order-card_h"><?php esc_html_e( 'Order Details', 'woocommerce' ); ?></h2>
			<table class="wc-account-order-details">
				<thead>
					<tr>
						<th class="wc-account-order-el_h"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
						<th class="wc-account-order-el_h"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach( $order->get_items() as $item_id => $item ) {
						$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );

						wc_get_template( 'order/order-details-item.php', array(
							'order'              => $order,
							'item_id'            => $item_id,
							'item'               => $item,
							'show_purchase_note' => $show_purchase_note,
							'purchase_note'      => $product ? get_post_meta( $product->id, '_purchase_note', true ) : '',
							'product'            => $product,
						) );
					}
					?>
					<?php do_action( 'woocommerce_order_items_table', $order ); ?>
				</tbody>
				<tfoot>
					<?php foreach ( $order->get_order_item_totals() as $key => $total ) { ?>
						<tr>
							<th class="wc-account-order-el_cnt text-right"><?php echo wp_kses($total['label'], 'post'); ?></th>
							<td class="wc-account-order-el_cnt"><?php echo wp_kses($total['value'], 'post'); ?></td>
						</tr>
					<?php } ?>
				</tfoot>
			</table>

			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

		</div>
	</div>

	<?php if ( $show_customer_details ) { ?>
		<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
	<?php } ?>

</div>
