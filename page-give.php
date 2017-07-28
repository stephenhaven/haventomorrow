<?php
/**
 * Template Name: Give Page
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

get_header(); ?>

		<?php while ( have_posts() ) : the_post();

			// get_sidebar('banner');
			get_template_part( 'template-parts/content', 'title' );  ?>


			<div class="section giveBanner story">
				<div class="full">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/graphic-giving-story.jpg" />
					<div class="info">
						<h1>Bibles for Cuba</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consequat leo ac tortor placerat placerat. Maecenas vitae neque ultricies, eleifend velit egestas, ornare felis. Fusce ultrices turpis eu quam commodo, vitae ullamcorper massa eleifend. Phasellus sagittis risus erat, ac pretium tellus dapibus nec. Etiam a quam lobortis, consequat nunc imperdiet, imperdiet ligula. Duis eget congue dui, ut euismod elit. Quisque ut vestibulum diam. Nulla eget urna venenatis, ultricies</p>
					</div><!--end .info-->
				</div><!--end .full-->
			</div><!--end .section-->

			<form>
				<div class="section give form1">
					<!-- <div class="notice">Order by phone: 800.654.2836</div> -->

					<h1>Gift Amount</h1>
					<hr class="blue" />

					<div class="checkboxes">
						<div class="checkbox">
							<span><span>select</span></span>$30
						</div>
						<div class="checkbox">
							<span><span>select</span></span>$50
						</div>
						<div class="checkbox">
							<span><span>select</span></span>$100
						</div>
						<div class="field">
							<span>Other</span>
							<div>
								<span>$</span>
								<input type="text" value="" />
							</div>
						</div>
					</div><!--end .checkboxes-->
					<div class="frequency">
						Frequency of your gift
						<div class="checkboxes">
							<div class="checkbox">
								<span><span>select</span></span>Monthly
							</div>
							<span class="tip">
								<span class="icon">icon</span>
								<span class="txt">If you choose "Monthly," this month's gift will be charged today. Beginning next month, all your monthly gifts will be charged on the 20th.</span>
							</span>
							<div class="checkbox">
								<span><span>select</span></span>One Time
							</div>
						</div><!--end .checkboxes-->
					</div><!--end .frequency-->
				</div><!--end .section-->

				<div class="section give form2">
					<div class="content">
						<div class="left">
							<div class="group">
								<h2>Personal Info</h2>
								<input class="short left" type="text" placeholder="First Name" />
								<input class="short right" type="text" placeholder="Last Name" />
								<input type="text" placeholder="Email" />
								<input class="mid" type="text" placeholder="Phone Number" />
							</div><!--end .group-->
							<div class="group">
								<h2>Billing Address</h2>
								<input type="text" placeholder="Street Address" />
								<input type="text" placeholder="Cont. (Optional)" />
								<input class="mid left" type="text" placeholder="City" />
								<input class="small right" type="text" placeholder="State" />
								<input class="short left" type="text" placeholder="Zip" id="billingZip"/>
								<input class="short right" type="text" placeholder="Country" />
							</div><!--end .group-->
						</div><!--end .left-->
						<div class="right">
							<div class="group">
								<h2>Credit Card</h2>
								<div class="ccNum">
									<span class="visa">Visa</span>
									<span class="mc on">MC</span>
									<span class="amex">AMEX</span>
									<span class="disc">Discover</span>
									<input type="text" placeholder="Number" />
								</div><!--end .ccNum-->
								<input class="small left" type="text" placeholder="MM" />
								<input class="small mid" type="text" placeholder="YY" />
								<span class="tip"><span class="icon">icon</span><span class="txt">tooltip info</span></span>
								<input class="small right" type="text" placeholder="CVC" />
							</div><!--end .group-->
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
								</div><!--end .checkboxes-->
							</div><!--end .group-->
							<div class="stations">
								<div class="item">
									<input type="radio" name="stations">
									<span class="name">107.9 <span>FM</span> KWVE</span>
									<span class="div">|</span>
									<span class="loc">Santa Ana/San Clemente, CA</span>
								</div><!--end .item-->
								<hr />
								<div class="item">
									<input type="radio" name="stations">
									<span class="name">91.3 <span>FM</span> KWTH</span>
									<span class="div">|</span>
									<span class="loc">Barstow, CA</span>
								</div><!--end .item-->
								<hr />
								<div class="item">
									<input type="radio" name="stations">
									<span class="name">88.9 <span>FM</span> KSDW</span>
									<span class="div">|</span>
									<span class="loc">Temecula, CA</span>
								</div><!--end .item-->
							</div><!--end .stations-->
						</div><!--end .right-->
					</div><!--end .content-->
					<button class="outlineBtn">Confirm Gift</button>
				</div><!--end .section-->
			</form>

		<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
