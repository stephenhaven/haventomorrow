$(document).ready(function() {
	// $('.cb-onetime').addClass('on');
	$('.cb-credit').addClass('on');

	//carry price over from woocommerce
	var price = $('#donation').attr('value');
	$('#recurringPrice').val(price);
	$('#donation').keyup(function(){
		price = $(this).val()
		$('#recurringPrice').val(price);
		$('#recurringPrice').attr('value', price);

		if(price >= 30){
			$('.benefits').show();
			$('.benefits input:radio').each(function(){
				$(this).prop('checked', true);
			});
		} else {
			$('.benefits').hide();
			$('.benefits input:radio').each(function(){
				$(this).prop('checked', false);
			});
		}

	});

	//get stations for recurring
	var $initBillingZipRecurring = $('#ba_zip').val();
	if ($initBillingZipRecurring.length == 5){
		$('.stations').empty();
		$('.stations').show();
		$('.stations').append('<div class="loading"><img src="/wp-content/themes/haven2015/images/ajax-loader-search-white.gif" alt="loading..."></div>');
		getStationsForChkout($initBillingZipRecurring);
	}

	$('#ba_zip').on('input', function(){
		var $billingZipRecurring = $('#ba_zip').val();
		if ($billingZipRecurring.length == 5) {
			$('.stations').empty();
			$('.stations').show();
			$('.stations').append('<div class="loading"><img src="/wp-content/themes/haven2015/images/ajax-loader-search-white.gif" alt="loading..."></div>');
			getStationsForChkout($billingZipRecurring);
		}
	});

	//shipping show/hide extra fields
	$('#shipping-option').click(function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$(".shippingContainer").hide();
		} else {
			$(this).addClass('on');
			$(".shippingContainer").show();
		}
	});

	$('.checkbox').click(function(){

		if($(this).hasClass('cb-monthly')){

			$(this).addClass('on');
			$('.cb-onetime').removeClass('on')
			$('.form2').hide();
			$('.formRecurring').show();
			$('.checkboxesType').show();
			$('.single_add_to_cart_button').hide();

		}

		if($(this).hasClass('cb-onetime')){

			$(this).addClass('on');
			$('.cb-monthly').removeClass('on')
			$('.form2').show();
			$('.formRecurring').hide();
			$('.checkboxesType').hide();
			$('.single_add_to_cart_button').show();
			$('.callout-warning').hide();

		}

		if($(this).hasClass('cb-checking')){

			$(this).addClass('on');
			$('.cb-credit').removeClass('on');
			$('.formRecurring .content .right .credit').hide();
			$('.formRecurring .content .right .checking').show();

			$('#recurringGiving').parsley().destroy();
			$('#recurringGiving').parsley({ excluded: ":hidden" }).on('field:validated', function() {
				var ok = $('.parsley-error').length === 0;
				$('.callout-warning').toggleClass('hidden', ok);
			});

		}

		if($(this).hasClass('cb-credit')){

			$(this).addClass('on');
			$('.cb-checking').removeClass('on');
			$('.formRecurring .content .right .credit').show();
			$('.formRecurring .content .right .checking').hide();

			$('#recurringGiving').parsley().destroy();
			$('#recurringGiving').parsley({ excluded: ":hidden" }).on('field:validated', function() {
				var ok = $('.parsley-error').length === 0;
				$('.callout-warning').toggleClass('hidden', ok);
			});

		}

	});
});
