<?php
/**
 * Composited Product Title.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/composited-product/title.php'.
 *
 * @version  3.1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<h4 class="composited_product_title product_title"><?php
	echo WC_CP_Product::get_title_string( apply_filters( 'woocommerce_composited_product_title', $title, $product_id, $component_id, $composite ), $quantity );
?></h4>
