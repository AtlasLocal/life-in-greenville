<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<div class="no-results-page">
	<p class="no-results-page_lbl __cart"><span class="icon-bag"></span></p>
	<h2 class="no-results-page_h"><?php esc_html_e( 'Your cart is currently empty.', 'woocommerce' ) ?></h2>
	<p class="no-results-page_lk-w return-to-shop">
		<a class="no-results-page_lk wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><span class="icon-arrow-left"></span>&nbsp;&nbsp;<?php esc_html_e( 'Return To Shop', 'woocommerce' ) ?></a>
	</p>
</div>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>
