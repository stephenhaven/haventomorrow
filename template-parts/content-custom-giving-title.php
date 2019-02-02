<?php
/**
 * Template part for displaying page title
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haventomorrow
 */

?>

<section class="c-padding-180 dark" style="background-image:url('https://new.haventoday.org/wp-content/uploads/2018/08/top-1.jpg')">
  <div class="container">
    <h1 class="is-center">Your gift will make a difference.</h1>
    <?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
  </div>
</section>

<section class="three-give">
  <div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-2">
          <img src="https://new.haventoday.org/wp-content/uploads/2018/09/phone.png">
        </div>
        <div class="col-md-10">
          <h3>PHONE</h3>
          <p><a href="tel:1-800-654-2836">1-800-654-2836</a></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-2">
          <img src="https://new.haventoday.org/wp-content/uploads/2018/09/mail.png">
        </div>
        <div class="col-md-10">
          <h3>MAIL</h3>
          <p><span style="color:#238698;">MAKE CHECKS PAYABLE TO:</span></br>
            HAVEN MINISTRIES</br>
            P.O. BOX 79997</br>
            RIVERSIDE, CA</br>
            92513-1997</p>
          </div>
        </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-2">
          <img src="https://new.haventoday.org/wp-content/uploads/2018/09/financial.png">
        </div>
        <div class="col-md-10">
            <h3>FINANCIAL ACCOUNTABILITY</h3>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="charles-give" style="background-image:url('https://new.haventoday.org/wp-content/uploads/2018/09/our-story.jpg')">
  <div class="vertical-align">
  <h1 class="is-center">OUR STORY</h1>
  <a href="https://www.youtube.com/watch?v=eU49qKXfRMc" target="_blank"><img src="https://new.haventoday.org/wp-content/uploads/2018/09/play.png"></a>
</div>
</section>

<section class="mission-give">
  <div class="container">
  <h1>OUR MISSION</h1>
  <h4>We engage and encourage people through digital, print, prayer, and broadcast ministries that are all about Jesus.</h4>
  </div>
</section>

<section class="other-give">
	<h2>OTHER WAYS TO GIVE</h2>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<p><strong style="color:#238698;">WILLS & ESTATES</strong></p>
			</div>
			<div class="col-md-4">
				<p><strong style="color:#238698;">PROPERY</strong></p>
			</div>
			<div class="col-md-4">
				<p><strong style="color:#238698;">STOCKS & MUTUAL FUNDS</strong></p>
			</div>
		</div>
		<div class="row justify-content-center">
			<a href="mailto:ministry@haventoday.org" class="o-button">Contact</a>
		</div>
	</div>
</section>
