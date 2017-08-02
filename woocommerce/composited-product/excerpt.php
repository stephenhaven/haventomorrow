<?php
/**
 * Composited Product Excerpt.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/composited-product/excerpt.php'.
 *
 * @version  2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $product_description ) {
	echo apply_filters( 'woocommerce_composited_product_excerpt', wpautop( do_shortcode( wp_kses_post( $product_description ) ) ), $product_id, $component_id, $composite );
}
