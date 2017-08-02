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
			get_template_part( 'template-parts/content', 'title' );

			the_content();
			?>


		<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
