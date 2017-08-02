<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// var_dump($product);
// $categories = get_the_category();
// var_dump($categories);

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		$product_categories = $product->get_categories();
		$pos = strpos($product_categories, 'Giving');

		if ($pos !== false) {
			$program_image = get_field('giving_banner_image');
			$program_content = get_field('giving_banner_content');
			$program_mobile_content = substr($program_content,0,70);
			$program_mobile_content = strip_tags($program_mobile_content);

			if (get_field('giving_banner_text_placement') == 'Right') {
				$placement = 'story';
			} else {
				$placement = 'gift';
			}
			if ($program_image['url'] != ""){
				echo '<div class="section giveBanner ' . $placement . '">';
				echo '<div class="full">';
				echo '<img src="' . $program_image['url'] . '" />';
				echo '<div class="info main">';
				echo $program_content;
				echo '</div><!--end .info-->';
				echo '<div class="info mobile">';
				echo '<div class="minContent">' . $program_mobile_content . '...<a href="javascript:;">Read More</a></div>';
				echo '<div class="allContent">' . $program_content . '<p><a href="javascript:;">Read Less</a></p></div>';
				echo '</div><!--end .info-->';
				echo '</div><!--end .full-->';
				echo '</div><!--end .section-->';
			}

		}
		$product_is_nyp = WC_Name_Your_Price_Helpers::is_nyp($product);

		if ($product->donation != '1' && $product->product_type != 'variable' && $product->product_type != 'composite' && $product_is_nyp != 1) {
			echo '<div class="left">';
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			echo '</div><!--end .left-->';

			echo '<div class="right first-right">';
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );

			echo '</div><!--end .right-->';
		}
		else {
			echo '<div id="give" class="section give form1">';
			echo '<div class="notice"><span>Give by phone: 800.654.2836</span></div>';
			do_action( 'woocommerce_single_product_summary' );
			echo '</div>';
		}
		echo '</div><!--end .section-->';
	?>


<?php if ($product->donation != '1' && $product->product_type != 'composite' && $product->product_type != 'variable') { ?>
<?php if ($product_is_nyp != 1) { ?>
	<div class="socialShare">
		<h4>Share</h4>
		<hr />
		<div class="addthis_toolbox">
			<div class="custom_images">
				<a class="addthis_button_facebook trans" addthis:url="<?php echo get_the_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-facebook"></i></a>
				<a class="addthis_button_twitter trans" addthis:url="<?php echo get_the_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-twitter"></i></a>
				<a class="addthis_button_email trans" addthis:url="<?php echo get_the_permalink(); ?>" addthis:title="<?php echo get_the_title(); ?>"><i class="fa fa-envelope"></i></a>
			</div>
		</div>
	</div><!--end .socialShare-->
<?php }} ?>

	<div class="section storeInner">
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	</div><!--end .section.storeInner-->

	<!-- <div class="section monthlyGift" style="display:none;">
	<div class="section give form2">
	<div class="content">
	<div class="left">
	<div class="group">
	<div class="woocommerce-billing-fields">
		<p class="form-row form-row short left validate-required" id="billing_first_name_field">
			<label for="billing_first_name" class="">First Name
				<abbr class="required" title="required">*</abbr>
			</label>
			<input type="text" class="input-text " name="billing_first_name" id="billing_first_name" placeholder="First Name" value="">
		</p>
		<p class="form-row form-row short right validate-required" id="billing_last_name_field">
			<label for="billing_last_name" class="">Last Name
				<abbr class="required" title="required">*</abbr>
			</label>
			<input type="text" class="input-text " name="billing_last_name" id="billing_last_name" placeholder="Last Name" value="">
		</p>
		<p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
			<label for="billing_address_1" class="">Address
				<abbr class="required" title="required">*</abbr>
			</label>
			<input type="text" class="input-text " name="billing_address_1" id="billing_address_1" placeholder="Street address" value="">
		</p>
		<p class="form-row form-row form-row-wide address-field" id="billing_address_2_field">
			<input type="text" class="input-text " name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="">
		</p>
		<p class="form-row form-row form-row-wide address-field validate-required" id="billing_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required">
			<label for="billing_city" class="">Town / City
				<abbr class="required" title="required">*</abbr>
			</label>
			<input type="text" class="input-text " name="billing_city" id="billing_city" placeholder="Town / City" value="">
		</p>
		<p class="form-row form-row form-row-first address-field validate-state woocommerce-invalid woocommerce-invalid-required-field validate-required" id="billing_state_field" data-o_class="form-row form-row form-row-first address-field validate-required validate-state woocommerce-invalid woocommerce-invalid-required-field">
			<label for="billing_state" class="">State
				<abbr class="required" title="required">*</abbr>
			</label>
			<div class="select2-container state_select" id="s2id_billing_state" style="width: 100%;">
				<a href="javascript:void(0)" class="select2-choice select2-default" tabindex="-1">   <span class="select2-chosen" id="select2-chosen-2">Select State...</span>
				<abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow" role="presentation"><b role="presentation"></b></span></a>
				<label for="s2id_autogen2" class="select2-offscreen">State
					<abbr class="required" title="required">*</abbr>
				</label>
				<input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-2" id="s2id_autogen2">
			</div><select name="billing_state" id="billing_state" class="state_select " placeholder="" tabindex="-1" title="State *" style="display: none;"><option value="">Select an option…</option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option><option value="AA">Armed Forces (AA)</option><option value="AE">Armed Forces (AE)</option><option value="AP">Armed Forces (AP)</option><option value="AS">American Samoa</option><option value="GU">Guam</option><option value="MP">Northern Mariana Islands</option><option value="PR">Puerto Rico</option><option value="UM">US Minor Outlying Islands</option><option value="VI">US Virgin Islands</option></select>
		</p>
		<p class="form-row form-row short right validate-postcode validate-required" id="billing_postcode_field" data-o_class="form-row form-row short right validate-required validate-postcode">
			<label for="billing_postcode" class="">Zip
				<abbr class="required" title="required">*</abbr>
			</label>
			<input type="text" class="input-text " name="billing_postcode" id="billing_postcode" placeholder="Zip">
		</p>
		<HR>
		<div id="divBankAcct" style="display:none;">
			<p class="form-row form-row short left validate-required" id="billing_bank_name_field">
				<label for="billing_bank_name" class="">Name of Your Bank
					<abbr class="required" title="required">*</abbr>
				</label>
				<input type="text" class="input-text " name="billing_bank_name" id="billing_bank_name" placeholder="Bank Name" value="">
			</p>
			<p class="form-row form-row short left validate-required" id="billing_account_name_field">
				<label for="billing_account_name" class="">Name on Account
					<abbr class="required" title="required">*</abbr>
				</label>
				<input type="text" class="input-text " name="billing_account_name" id="billing_account_name" placeholder="Account Name" value="">
			</p>
		</div>
		<div id="divCreditCard" style="display:none;">

		</div>
	</div></div></div>
	<div class="right">
		<div class="group options">
			<h2>Where do you primarily listen to haven today?</h2>
			<div class="checkboxes">
				<div class="checkbox">
					<span><span>select</span></span>Mobile App
				</div>
				<div class="checkbox">
					<span><span>select</span></span>Internet
				</div>
				<div class="checkbox">
					<span><span>select</span></span>Other / I don't know
				</div>
				<div class="checkbox">
					<span><span>select</span></span>I Don't Listen to Haven Today
				</div>
			</div>
		</div>
		<div class="stations" style="display: block;">
			<div class="item">
			<input type="radio" name="stations" value="  660-AM">
				<span class="name">  660<span>AM</span> KWVE-AM</span><span class="div">|</span><span class="loc">Bakersfield, California</span></div>
			<hr>
			<div class="item">
			<input type="radio" name="stations" value="107.9-FM">
				<span class="name">107.9<span>FM</span> KWVE-FM</span><span class="div">|</span><span class="loc">SantaAna/SanClemente, California</span></div>
			<hr>
		</div>
	</div>
	</div></div></div><!--end .section.monthlyGift-->

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
<section class="__queenyearend">
	<div class="c-content">
		<!-- <div class="c-container">
			<h1>Thank You</h1>
		<p>Thank you for your generous support of Haven at the close of 2016! Your gift is a great help as we aim to raise $755,000 by December 31st to continue broadcasting on more than 600 stations, producing and distributing Anchor Devotional, and pursuing our mission of telling the Great Story that’s all about Jesus.</p>
	</div> -->
	</div>
	<!-- <div class="c-video">
		<div class="c-container">
		<div class="videoWrapper">
	    <iframe src="https://player.vimeo.com/video/157486311?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		</div>
	</div>
	</div> -->
</section>
<div class="section sub">
	<hr>
	<div class="financial-accountability content">
	<p><img src="https://www.haventoday.org/wp-content/uploads/2016/08/ecfa-badge.png" width="100px"><p>
	</div>
</div>
