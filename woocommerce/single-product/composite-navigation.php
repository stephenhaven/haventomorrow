<?php
/**
 * Composite navigation template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/composite-navigation.php'.
 *
 * @version  3.2.1
 * @since    2.5.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><div id="composite_navigation_<?php echo $product->id; ?>" class="composite_navigation <?php echo esc_attr( $classes ); ?>" <?php echo $navigation_style === 'progressive' ? 'style="display:none"' : ''; ?>>
	<a class="page_button prev" href="#"></a>
	<a class="page_button next" href="#"></a>
</div>
