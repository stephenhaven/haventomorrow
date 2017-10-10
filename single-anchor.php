<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

get_header();
get_template_part( 'template-parts/content', 'anchor-title' ); ?>

		<div class="section anchor sub">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'anchor'); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!--end .section-->

<?php get_footer(); ?>
