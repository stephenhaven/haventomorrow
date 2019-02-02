<?php
/**
 * Template Name: Checkout/Cart Page
 */

get_header();

		while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'title' );

			the_content();

			/*
			 * Hello, my fellow kids.
			 * Below here, we have the solution I came up with after several days of WooCommerce fighting to convert the textfield
			 * for credit card expiration into a dropdown menu.
			 * 
			 * - First, we generate invisible HTML that has the dropdowns we want.
			 * - Second, we make the default expiration field totally invisible.
			 * - Third, we append our dropdown HTML after the invisible form field.
			 * - Fourth, we use jQuery events to listen for dropdown menu changes. When it changes,
			 *   we convert the dropdown values into a textfield and inject it into the hidden field.
			 * 
			 * The result of this is that we can successfully use dropdowns without modifying the WooCommerce 
			 * plugin as the plugin developer recommended. Very thankful.
			 */

			?>

			<div id="ccDropdown" style="display: none;">
				<select id="ccMonthDropdown">
					<option value=""><?php esc_html_e( 'Month', 'woocommerce-gateway-authorize-net-aim' ) ?></option>
					<?php foreach ( range( 1, 12 ) as $month ) : ?>
						<option value="<?php printf( '%02d', $month ) ?>"><?php printf( '%02d', $month ) ?></option>
					<?php endforeach; ?>
				</select>
				<select id="ccYearDropdown">
					<option value=""><?php esc_html_e( 'Year', 'woocommerce-gateway-authorize-net-aim' ) ?></option>
					<?php foreach ( range( date( 'Y' ), date( 'Y' ) + 10 ) as $year ) : ?>
						<option value="<?php echo $year ?>"><?php echo $year ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<script type="text/javascript">

				$(document).ready(function() {

					$('#wc-authorize-net-aim-expiry').css("display", "none"); // Make the expiration field invisible.
					$('#wc-authorize-net-aim-expiry').val(''); // Clear the invisible form field.
					$("#wc-authorize-net-aim-expiry").after($('#ccDropdown').detach()); // Detach the dropdown from the theme page and append to invisible field.
					$('#ccDropdown').css("display", "block"); // Show that dropdown menu now.
					$('#ccMonthDropdown').prop('selectedIndex', 0); // Put month dropdown as position 1.
					$('#ccYearDropdown').prop('selectedIndex', 0); // Put year dropdown as position 1.

					// Handles updating the invisible field when the cc dropdowns change.
					function updateDropdown() {

						// Extract dropdown values.
						var monthDropdownVal = $('#ccMonthDropdown').val();
						var yearDropdownVal = $('#ccYearDropdown').val();

						// Make sure both values are set.
						if (monthDropdownVal == '' || yearDropdownVal == '') {
							return;
						}

						// Update the invisible field.
						$('#wc-authorize-net-aim-expiry').val(monthDropdownVal + "/" + yearDropdownVal.slice(-2));

					}

					// Bind the dropdown change events.
					$('#ccMonthDropdown').change(updateDropdown);
					$('#ccYearDropdown').change(updateDropdown);

				});

			</script>

			<?php

		endwhile;

get_footer(); ?>
