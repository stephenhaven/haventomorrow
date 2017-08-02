<?php
/**
 * Composited Variable Product Template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/composited-product/variable-product.php'.
 *
 * @version  3.2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><div class="details component_data" data-component_set="" data-price="0" data-regular_price="0" data-product_type="variable" data-product_variations="<?php echo esc_attr( json_encode( $product_variations ) ); ?>" data-custom="<?php echo esc_attr( json_encode( $custom_data ) ); ?>"><?php

	/**
	 * Composited product details template
	 *
	 * @hooked wc_cp_composited_product_excerpt - 10
	 */
	do_action( 'woocommerce_composited_product_details', $product, $component_id, $composite_product );

	?><table class="variations" cellspacing="0">
		<tbody><?php
			//var_dump($product_variations[0]['is_nyp']);
			//var_dump($product_variations[0]);
			//var_dump($product_variations[1]);
			foreach ( $attributes as $attribute_name => $options ) {
				?><tr class="attribute-options" data-attribute_label="<?php echo wc_attribute_label( $attribute_name ); ?>">
					<td class="label">
						<label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?> <abbr class="required" title="required">*</abbr></label>
					</td>
					<td class="value">

					<div class="checkboxes">
					<?php
						$selected = isset( $_REQUEST[ 'wccp_attribute_' . sanitize_title( $attribute_name ) ][ $component_id ] ) ? wc_clean( $_REQUEST[ 'wccp_attribute_' . sanitize_title( $attribute_name ) ][ $component_id ] ) : wc_composite_get_variation_default_attribute( $product, $attribute_name );
						wc_composite_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
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

						foreach ( $product_variations as $each_variation ) {
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
						
						// if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
							// $attributes = $product->get_variation_attributes();
							// $options    = $attributes[ $attribute ];	
						// }
						// if ( ! empty( $options ) ) {
							// foreach ( $options as $option ) {
								// //var_dump($component_id);
								// //echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( $args['selected'], sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
								// if ($option == "Other"){
									// //$product_id = $product->id;
									// $product_id = 1594;
									// $prefix = '-' . $component_id;
									// echo '<div class="field">';
									// wc_get_template(
										// 'single-product/price-input.php',
										// array( 'product_id' => $product_id,
												// 'prefix' 	=> $prefix ),
										// FALSE,
										// WC_Name_Your_Price()->plugin_path() . '/templates/' );			
									// echo '</div>';								
								// }
								// else {
									// echo '<div class="checkbox" data-value="' . esc_attr( sanitize_title( $option ) ) . '">';
									// echo '<span><span>select</span></span>$' . esc_attr( sanitize_title( $option ) );
									// echo '</div>';									
								// }
								// // echo '<div class="field">';
								// // echo '<span>Other</span>';
								// // echo '<div>';
								// // echo '<span>$</span>';
								// // echo '<input type="text" value="" />';
								// // echo '</div>';
								// // echo '</div>';								
							// }
						// }
					?>
					</div><!--end .checkboxes-->
					</td>
				</tr><?php
			}

		?></tbody>
	</table><?php

	do_action( 'woocommerce_composited_product_add_to_cart', $product, $component_id, $composite_product );

	?><div class="single_variation_wrap component_wrap" style="display:none;">

		<div class="single_variation"></div>
		<div class="variations_button">
			<input type="hidden" name="variation_id" value="" /><?php

		 		wc_get_template( 'composited-product/quantity.php', array(
					'quantity_min'      => $quantity_min,
					'quantity_max'      => $quantity_max,
					'component_id'      => $component_id,
					'product'           => $product,
					'composite_product' => $composite_product
				), '', WC_CP()->plugin_path() . '/templates/' );

		 ?></div>
	</div>
</div>
