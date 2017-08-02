<?php
/**
 * Single Product Suggested Price, including microdata for SEO
 */

global $product, $WC_Donations;

if ( isset( $_POST['donation'] ) &&  floatval( $_POST['donation'] ) >= 0 ) {

	$num_decimals = ( int ) get_option( 'woocommerce_price_num_decimals' );

	$price = round( floatval( $_POST['donation'] ), $num_decimals );

} elseif ( $product->suggested && floatval( $product->suggested ) > 0 ) {

	$price = $product->suggested;

} elseif ( $product->minimum && floatval( $product->minimum ) > 0 ) {

	$price =  $product->minimum;

} else {

	$price = '';
}

?>

<div class="donation">
	<div class="field">
	<span>
		<?php
			if ( $product->minimum && floatval( $product->minimum ) > 0 ){
				printf( _x( '%s ( %s )', 'In case you need to change the order of Your Donation ( $currency_symbol )', 'woocommerce' ), 'My Gift for Haven', get_woocommerce_currency_symbol() );
			}
			else {
				printf( _x( '%s ( %s )', 'In case you need to change the order of Your Donation ( $currency_symbol )', 'woocommerce' ), get_option( 'woocommerce_donation_label_text', __('Your Donation', 'woocommerce' ) ), get_woocommerce_currency_symbol() );
			}
		?>
	</span>
	<div>
		<?php echo $WC_Donations->donation_input_helper( esc_attr( $price ), array( 'name'=>'donation' )); ?>
	</div>
	</div><!--end .field-->
	<span class="desc">
	<?php
	if ( $product->minimum && floatval( $product->minimum ) > 0 ){
		printf( _x( 'Minimum %s%s gift required', '$', '5' ), get_woocommerce_currency_symbol(), number_format(floatval( $product->minimum ),2,'.','' ));
	}
	?>
	</span>
</div>


<?php if($product->recurring){ ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/recurring.js"></script>
<div class="frequency">
	Frequency of your gift
	<div class="checkboxes">
		<div class="checkbox cb-monthly">
			<span><span>select</span></span>Monthly
		</div>
		<div class="monthlytip">
			<span class="tip">
				<span class="icon">icon</span>
				<span class="txt">
					When you sign up for automatic monthly giving, not only are you helping Haven Ministries continue to broadcast the great story of Jesus, but you also become a full member of Haven Partners.<br><br>
					Haven Partners giving $30 or more each month are eligible to receive the following monthly benefits:<br>
					Haven's Monthly Insider Newsletter.<br>
					The Rest of the Story Resource.<br>
					Access to the Haven Tech Desk.<br>
					And the opportunity to request the featured book or CD each month.<br><br>

					Your recurring monthly gift can be cancelled anytime. If you have any questions, please call LaHanna Lopez at 1-877-754-2836, ext. 1116.
				</span>
			</span>
			<div class="checkbox cb-onetime">
				<span><span>select</span></span>One Time
			</div>
		</div>
	</div><!--end .checkboxes-->
	<div class="checkboxes checkboxesType">
		<!-- <div class="checkbox checkboxLong cb-checking">
			<span><span>select</span></span>Bank Account
		</div> -->
		<div class="checkbox cb-credit">
			<span><span>select</span></span>Credit Card
		</div>

		<div class="gifttextmonthly">
			If your monthly gift is $30.00 or more you are eligible to receive the monthly benefits of Haven Partners
			<p style="color:#268398"><strong>If you would like to make a monthly donation via a bank account, please call us at 1-800-654-2836.</strong></p>
			<div class="monthlytip2">
				<span class="tip">
					<span class="icon">icon</span>
					<span class="txt">
						When you sign up for automatic monthly giving, not only are you helping Haven Ministries continue to broadcast the great story of Jesus, but you also become a full member of Haven Partners.<br><br>
						Haven Partners giving $30 or more each month are eligible to receive the following monthly benefits:<br>
						Haven's Monthly Insider Newsletter.<br>
						The Rest of the Story Resource.<br>
						Access to the Haven Tech Desk.<br>
						And the opportunity to request the featured book or CD each month.<br><br>

						Your recurring monthly gift can be cancelled anytime. If you have any questions, please call LaHanna Lopez at 1-877-754-2836, ext. 1116.
					</span>
				</span>
			</div>
		</div>

	</div><!--end .checkboxes-->
</div><!--end .frequency-->

<?php } ?>
