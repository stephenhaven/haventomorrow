<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">
						<div class="checkboxes">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
								echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#" style="display:none;">' . __( 'Clear selection', 'woocommerce' ) . '</a>' : '';

								$args = array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected );
								$args = wp_parse_args( $args, array(
									'options'          => false,
									'attribute'        => false,
									'product'          => false,
									'selected' 	       => false,
									'name'             => '',
									'id'               => '',
									'show_option_none' => __( 'Choose an option', 'woocommerce' )
								) );

								$options   = $args['options'];
								$product   = $args['product'];
								$attribute = $args['attribute'];
								$name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
								$id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );

								if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
									$attributes = $product->get_variation_attributes();
									$options    = $attributes[ $attribute ];
								}

								foreach ( $available_variations as $each_variation ) {
									if ($each_variation['is_nyp']){
										$product_id = $each_variation['variation_id'];
										$prefix = '-' . $component_id;
										echo '<div class="field" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-variation="' . esc_attr(json_encode($each_variation)) . '">';
										wc_get_template(
											'single-product/price-input.php',
											array( 'product_id' => $product_id,
													'prefix' 	=> $prefix ),
											FALSE,
											WC_Name_Your_Price()->plugin_path() . '/templates/' );			
										echo '</div>';								
									}
									else {
										echo '<div class="checkbox" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-variation="' . esc_attr(json_encode($each_variation)) . '" data-value="' . esc_attr( sanitize_title( $each_variation['display_price'] ) ) . '">';
										echo '<span><span>select</span></span>$' . esc_attr( sanitize_title( $each_variation['display_price'] ) );
										echo '</div>';									
									}
								}
							?>
						</div>
						</td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:block;">
			<?php
				/**
				 * woocommerce_before_single_variation Hook
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
