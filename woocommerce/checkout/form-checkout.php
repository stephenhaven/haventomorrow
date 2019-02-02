<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<?php
	global $product;

	$product_has_chained = SA_WC_Chained_Products::has_chained_products( $product->id );
	$product_is_nyp = WC_Name_Your_Price_Helpers::is_nyp($product);
	$product_terms = get_the_terms($product->id, 'product_cat');
	$product_is_giving = false;
	foreach ($product_terms as $term) {
		if ($term->name == "Giving"){
			$product_is_giving = true;
			break;
		}
	}

	if ($product->donation == '1' || $product->product_type == 'composite' || $product->product_type == 'variable' || $product_is_nyp == 1) {
		echo '<div class="section give form2">';
	}

	$linkProduct = get_field('select_donation_gift',$product->id);
	if ($linkProduct != ""){
		$checkout->force_shipping = true;
	}

?>
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
		<div class="content">
			<div class="left">
			<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div class="group">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<?php
						// var_dump($product_terms);
						// var_dump($product_has_chained);
						// die();

						if (($product->donation != '1' && !$product_is_giving) || $product_has_chained == 1) { ?>
							<div class="group">
								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
					<?php
						}
					?>

				<?php
					do_action( 'woocommerce_checkout_after_customer_details' );
				?>

			</div>
			<?php endif; ?>
			<div class="right first-right">
				<input type="hidden" id="listen_radio" name="listen_radio" value="">
				<div class="group options">
					<h2>Where do you primarily listen to haven today?</h2>
					<div class="checkboxes">
						<div class="checkbox" data-value="Mobile App">
							<span><span>select</span></span>Mobile App
						</div>
						<div class="checkbox" data-value="Internet">
							<span><span>select</span></span>Internet
						</div>
						<div class="checkbox" data-value="Do Not Know">
							<span><span>select</span></span>Other / I don't know
						</div>
						<div class="checkbox" data-value="Do Not Listen">
							<span><span>select</span></span>I Don't Listen to Haven Today
						</div>
					</div><!--end .checkboxes-->
				</div>

				<div class="stations">
					<div class="item">
						<input type="radio" name="radio_station" value="107.9">
						<span class="name">107.9 <span>FM</span> KWVE</span>
						<span class="div">|</span>
						<span class="loc">Santa Ana/San Clemente, CA</span>
					</div>
					<hr>
					<div class="item">
						<input type="radio" name="radio_station" value="91.3">
						<span class="name">91.3 <span>FM</span> KWTH</span>
						<span class="div">|</span>
						<span class="loc">Barstow, CA</span>
					</div>
					<hr>
					<div class="item">
						<input type="radio" name="radio_station" value="88.9">
						<span class="name">88.9 <span>FM</span> KSDW</span>
						<span class="div">|</span>
						<span class="loc">Temecula, CA</span>
					</div>
				</div>

				<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
						
				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			</div>

		</div>
	</form>
<?php
	if ($product->donation == '1') {
		echo '</div><!--end .section-->';
	}
?>

	<script src="<?php echo get_template_directory_uri(); ?>/js/wc-checkout.js"></script>

<?php
	do_action( 'woocommerce_after_checkout_form', $checkout );
?>
