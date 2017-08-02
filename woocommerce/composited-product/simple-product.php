<?php
/**
 * Composited Simple Product Template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/composited-product/simple-product.php'.
 *
 * @version  3.3.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><div class="details component_data" data-component_set="true" data-price="<?php echo $price; ?>" data-regular_price="<?php echo $regular_price; ?>" data-product_type="simple" data-custom="<?php echo esc_attr( json_encode( $custom_data ) ); ?>"><?php

	/**
	 * Composited product details template
	 *
	 * @hooked wc_cp_composited_product_excerpt - 10
	 */
	do_action( 'woocommerce_composited_product_details', $product, $component_id, $composite_product );

	?><div class="component_wrap"><?php

		/**
		 * Composited product add-to-cart fields template
		 *
		 * @hooked wc_cp_composited_product_price - 8
		 */
		do_action( 'woocommerce_composited_product_add_to_cart', $product, $component_id, $composite_product );

		$availability = WC_CP()->api->get_composited_item_availability( $product, $quantity_min );

		if ( $availability[ 'availability' ] ) {
			echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability[ 'class' ] ) . '">' . esc_html( $availability[ 'availability' ] ) . '</p>', $availability[ 'availability' ] );
	    }

		?><div class="quantity_button"><?php

	 		wc_get_template( 'composited-product/quantity.php', array(
				'quantity_min'      => $quantity_min,
				'quantity_max'      => $product->is_in_stock() ? $quantity_max : $quantity_min,
				'component_id'      => $component_id,
				'product'           => $product,
				'composite_product' => $composite_product
			), '', WC_CP()->plugin_path() . '/templates/' );

		?></div>
	</div>
</div>

