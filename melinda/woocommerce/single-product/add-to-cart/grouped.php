<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.1.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;

$parent_product_post = $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="product_add-to-cart-w" method="post" enctype='multipart/form-data'>
	<table cellspacing="0" class="product-group">
		<?php
			foreach ( $grouped_products as $product_id ) {
				if ( ! $product = wc_get_product( $product_id ) ) {
					continue;
				}

				if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && ! $product->is_in_stock() ) {
					continue;
				}

				$post    = $product->post;
				setup_postdata( $post );
				?>
				<tr>
					<td>
						<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
							<?php woocommerce_template_loop_add_to_cart(); ?>
						<?php else : ?>
							<?php
								$quantites_required = true;
								woocommerce_quantity_input( array(
									'class' => '__bold_round',
									'input_name' => 'quantity[' . $product_id . ']',
									'input_value' => '0',
									'min_value' => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
									'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ) 
								) );
							?>
						<?php endif; ?>
					</td>

					<td class="label">
						<label for="product-<?php echo esc_attr($product_id); ?>">
							<?php
							if ($product->is_visible()) {
								echo '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink(), $product_id ) ) . '">' . esc_html( get_the_title() ) . '</a>';
							} else {
								esc_html( get_the_title() );
							}
							?>
						</label>
					</td>

					<?php do_action ( 'woocommerce_grouped_product_list_before_price', $product ); ?>

					<td class="price">
						<?php
						echo wp_kses($product->get_price_html(), 'post');

						if ( $availability = $product->get_availability() ) {
							$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
							echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
						}
						?>
					</td>
				</tr>
				<?php
			}

			// Reset to parent grouped product
			$post    = $parent_product_post;
			$product = wc_get_product( $parent_product_post->ID );
			setup_postdata( $parent_product_post );
		?>
	</table>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>">

	<?php if ( $quantites_required ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<button type="submit" class="single_add_to_cart_button button alt"><span class="icon-bag"></span> <span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
