<?php
/**
 * Template Name: Checkout/Cart Page
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

get_header(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

		    <?php the_content(); ?>

		<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
