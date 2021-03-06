<?php
/**
 * Composite Product Template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/add-to-cart/composite.php'.
 *
 * @version 3.0.0
 * @since  2.4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><form method="post" enctype="multipart/form-data" class="composite_form" style="visibility:hidden;"><?php

	$loop 	= 0;
	$steps 	= count( $components );

	/**
	 * woocommerce_composite_before_components hook
	 *
	 * @hooked wc_cp_add_paged_mode_select_component_option_scroll_target_thumbnails - 5
	 * @hooked wc_cp_add_paged_mode_show_component_scroll_target - 10
	 * @hooked wc_cp_add_paged_mode_pagination - 15
	 * @hooked wc_cp_add_navigation_top - 20
	 */
	do_action( 'woocommerce_composite_before_components', $components, $product );

	foreach ( $components as $component_id => $component_data ) {

		$loop++;

		if ( $navigation_style == 'single' ) {

			wc_get_template( 'single-product/component-single-page.php', array(
				'product'                 => $product,
				'component_id'            => $component_id,
				'component_data'          => $component_data,
				'step'                    => $loop,
				'steps'                   => $steps,
			), '', WC_CP()->plugin_path() . '/templates/' );

		} elseif ( $navigation_style == 'progressive' ) {

			wc_get_template( 'single-product/component-single-page-progressive.php', array(
				'product'                 => $product,
				'component_id'            => $component_id,
				'component_data'          => $component_data,
				'step'                    => $loop,
				'steps'                   => $steps,
			), '', WC_CP()->plugin_path() . '/templates/' );

		} else {

			wc_get_template( 'single-product/component-multi-page.php', array(
				'product'                 => $product,
				'component_id'            => $component_id,
				'component_data'          => $component_data,
				'step'                    => $loop,
				'steps'                   => $steps,
			), '', WC_CP()->plugin_path() . '/templates/' );

		}
	}

	/**
	 * woocommerce_composite_after_components hook
	 *
	 * @hooked wc_cp_add_paged_mode_cart - 10
	 * @hooked wc_cp_add_single_mode_cart - 10
	 * @hooked wc_cp_add_component_messages - 15
	 * @hooked wc_cp_add_navigation_bottom - 15
	 * @hooked wc_cp_add_paged_mode_select_component_option_scroll_target_dropdowns - 20
	 */
	do_action( 'woocommerce_composite_after_components', $components, $product );

?></form>
