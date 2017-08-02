<?php
/**
 * Checkout login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
	return;
}

$info_message  = apply_filters( 'woocommerce_checkout_login_message', __( 'Already have an account?', 'woocommerce' ) );
$info_message .= ' <a href="#" class="showlogin">' . __( 'Click here to login', 'woocommerce' ) . '</a>';
wc_print_notice( $info_message, 'notice' );
?>

<div class="canada_ip">
	<p><em>Looking for Haven Canada? <a href="http://www.havencanada.com">Click here</a></em></p>
</div>

<?php
	woocommerce_login_form(
		array(
			'message'  => __( 'If you have an account, please enter your username or email address and password in the boxes below. If you don\'t have an account, please proceed to the Billing &amp; Shipping section.', 'woocommerce' ),
			'redirect' => wc_get_page_permalink( 'checkout' ),
			'hidden'   => true
		)
	);
?>
