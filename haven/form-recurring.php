<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="/wp-content/themes/haven2015/js/parsley.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/haven2015/css/parsley.css" type="text/css" />
<script type="text/javascript">
$(function () {
  $('#recurringGiving').parsley({ excluded: ":hidden" }).on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.callout-warning').toggleClass('hidden', ok);
  });

  $('#recurringGiving').parsley().on('form:submit', function() {
  $('.confirmgift').fadeOut(function(){
	  $('.processinggift').fadeIn();
  });
});

});
</script>

<div class="callout-warning hidden">
  There are some validation errors. Please verify all fields are correct and that the donation amount is greater than $5.00
</div>

<form id="recurringGiving" method="post" action="/wp-content/themes/haven2015/woocommerce/haven/process-recurring.php">
<div class="section give form2 formRecurring" style="display:none;">
	<div class="content">
		<div class="left">
			<div class="group">
				<h2>Personal Info</h2>
				<input class="short left" type="text" placeholder="First Name" name="pi_firstname" required="" />
				<input class="short right" type="text" placeholder="Last Name" name="pi_lastname" required="" />
				<input type="email" placeholder="Email" name="pi_email" data-parsley-trigger="change" required=""/>
				<input class="mid" type="text" placeholder="Phone Number" name="pi_phone" required=""/>
			</div><!--end .group-->
			<div class="group">
				<h2>Billing Address</h2>
				<input type="text" placeholder="Street Address" name="ba_street" required=""/>
				<input type="text" placeholder="Cont. (Optional)" name="ba_streetadditional" />
				<input class="mid left" type="text" placeholder="City" name="ba_city" required=""/>
				<input class="small right" type="text" placeholder="State" name="ba_state" required=""/>
				<input class="short left" type="text" placeholder="Zip" id="ba_zip" name="ba_zip" required=""/>
				<input class="short right" type="text" placeholder="Country" name="ba_country" required=""/>
			</div><!--end .group-->
			<div class="shipping">
				<input type="checkbox" name="shipping" id="shipping-option" value="shipping" name="option_shipping"><label for="shipping-option"><h3>Ship to a different address</h3></label>
			</div>
			<div class="group shippingContainer">
				<h2>Shipping Address</h2>
				<input class="short left" type="text" placeholder="First Name" name="sa_firstname" required=""/>
				<input class="short right" type="text" placeholder="Last Name" name="sa_lastname" required=""/>
				<input type="text" placeholder="Street Address" name="sa_street" required=""/>
				<input type="text" placeholder="Cont. (Optional)" name="sa_streetadditional"/>
				<input class="mid left" type="text" placeholder="City" name="sa_city" required=""/>
				<input class="small right" type="text" placeholder="State" name="sa_state" required=""/>
				<input class="short left" type="text" placeholder="Zip" name="sa_zip" required=""/>
				<input class="short right" type="text" placeholder="Country" name="sa_country" required=""/>
			</div><!--end .group-->

			<div class="group">
				<h2>Questions and Comments?</h2>
				<textarea rows="4" cols="50" name="pi_questions"></textarea>
			</div>

		</div><!--end .left-->
		<div class="right">
			<div class="group credit">
				<h2>Credit Card</h2>
				<!--<div class="ccNum">
					<span class="visa">Visa</span>
					<span class="mc">MC</span>
					<span class="amex">AMEX</span>
					<span class="disc">Discover</span>
					<input type="text" placeholder="Number" name="finance_cc" data-parsley-type="number" required="" />
				</div>--><!--end .ccNum-->
				<input type="text" placeholder="Number" name="finance_cc" data-parsley-type="number" required="" data-parsley-length="[13, 19]" />
				<input class="small left" type="text" placeholder="MM" name="finance_cc_month" data-parsley-type="number" required="" data-parsley-length="[2, 2]"/>
				<input class="small mid" type="text" placeholder="YY" name="finance_cc_year" data-parsley-type="number" required="" data-parsley-length="[2, 2]"/>
				<span class="tip"><span class="icon">icon</span><span class="txt">Visa®, Mastercard®, and Discover® cardholders:<br />Turn your card over and look at the signature box. You should see either the entire 16-digit credit card number or just the last four digits followed by a special 3-digit code. This 3-digit code is your CVV number / Card Security Code.<br /><br />CID<br />American Express® cardholders:<br />Look for the 4-digit code printed on the front of your card just above and to the right of your main credit card number. This 4-digit code is your Card Identification Number (CID).</span></span>
				<input class="small right" type="text" placeholder="CVC" name="finance_cc_cvc" required="" data-parsley-length="[3, 4]"/>
			</div><!--end .group-->
			<div class="group checking">
				<h2>Name of Your Bank</h2>
				<input type="text" placeholder="" required="" name="finance_bank" /><br /><br />

				<h3>Account Type</h3>
				<input type="radio" name="account_type" value="checking" id="recurring-checking" name="finance_accounttype" checked> <label for="recurring-checking">Checking</label> &nbsp;&nbsp;&nbsp;<input type="radio" name="account_type" id="recurring-savings" name="finance_accounttype" value="savings"> <label for="recurring-savings">Savings</label><br /><br />

				<h2>Name on Account</h2>
				<input type="text" placeholder="" required="" name="finance_accountname" />
				<img src="<?php echo get_template_directory_uri(); ?>/images/check-example.jpg">

				<div class="checkdetail">
					<div class="routing">
						<h2>Routing #</h2>
						<input type="text" placeholder="" name="finance_routing" data-parsley-type="number" required="" data-parsley-length="[9, 9]" />
					</div>
					<div class="account">
						<h2>Account #</h2>
						<input type="text" placeholder="" name="finance_account" data-parsley-type="number" required="" data-parsley-length="[12, 12]" />
					</div>
				</div>
			</div><!--end .group-->
			<div class="group">
				<div class="processdonation">
					Process my donation on the <select name="finance_process"><option value="1st">1st</option><option value="15th">15th</option></select> of each month.
				</div>

				<i>For security purposes, we require you to choose a question below and submit your answer. We will use this question to verify your identity over the phone before disussing your account with you.</i><br /><br />

				<h2>Security Question</h2>
				<select name="finance_securityquestion" required="">
				  <option value="">(select one)</option>
				  <option value="mothersname">Your mother's maiden name</option>
				  <option value="petsname">Your pet's name</option>
				  <option value="sportsteam">Your favorite sports team</option>
				</select>

				<h2>Security Answer</h2>
				<input type="text" placeholder="" name="finance_securityanswer" required=""/>
			</div><!--end .group-->
			<div class="group options nospace">
				<h2>Where do you primarily listen to haven today?</h2>
				<div class="checkboxes">
					<div class="checkbox">
						<span><span>select</span></span>My local radio station
					</div>
					<div class="checkbox">
						<span><span>select</span></span>Mobile App
					</div>
					<div class="checkbox">
						<span><span>select</span></span>Internet
					</div>
					<div class="checkbox">
						<span><span>select</span></span>Other / I don't know
					</div>
				</div><!--end .checkboxes-->
			</div><!--end .group-->

			<div class="stations">
				<!--POPULATED WITH AJAX-->
			</div><!--end .stations-->

			<div class="benefits" style="display:none;">
				<h2>Benefits Preference</h2>
				<div class="item">
					<div style="display:inline-block; width:8%; vertical-align:top;"><input type="radio" name="optin" value="true" id="benefits-optin"></div>
					<div style="display:inline-block; width:90%;"><label for="benefits-optin">Yes! I want to receive the Haven Partners monthly benefits. Benefits include: Haven's Monthly Insider Newsletter, The Rest of the Story resource, access to the Haven Tech Desk, and the opportunity to request the featured book or CD each month. I understand that my tax-deductible donation will be reduced by the fair market value of all products received.</label></div>
				</div>
				<div class="item">
					<div style="display:inline-block; width:8%; vertical-align:top;"><input type="radio" name="optin" value="false" id="benefits-optout"></div>
					<div style="display:inline-block; width:90%;"><label for="benefits-optout">No, thank you. Please do not send me any Haven Partner mailings or offers. I want my full donation to go to Haven.</label></div>
				</div>
			</div><!--end .benefits-->

		</div><!--end .right-->
	</div><!--end .content-->
	<?php
		$linked_product_obj = get_field('recurring_product');
		$linked_product_permalink = get_the_permalink($linked_product_obj->ID);
	?>
	<input id="linkedProduct" style="display:none;" name="linked_product_title" value='<?php echo $linked_product_obj->post_title; ?>'>
	<input id="linkedProduct" style="display:none;" name="linked_product_id" value='<?php echo $linked_product_obj->ID; ?>'>
	<input id="linkedProduct" style="display:none;" name="linked_product_link" value='<?php echo $linked_product_permalink ?>'>
	<input id="recurringPrice" style="opacity:0; float:left; width:0px; height:0px;" name="price" value="" step="0.01" type="number" required data-parsley-min="5">
	<button class="outlineBtn confirmgift">Confirm Gift</button>
	<div class="processinggift" style="display:none;"><br /><img src="/wp-content/themes/haven2015/images/ajax-loader-search-white.gif"><br />Processing, please wait...</div>
</div><!--end .section-->
</form>
