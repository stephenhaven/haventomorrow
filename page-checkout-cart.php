<?php
/**
 * Template Name: Checkout/Cart Page
 */

get_header();

		while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'title' );

		    the_content();

		endwhile;

get_footer(); ?>
