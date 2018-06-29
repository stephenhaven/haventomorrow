<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package haventomorrow
 */

get_header();
get_template_part( 'template-parts/content', 'title-custom' ); ?>

<section class="c-padding-75">
  <div class="container">

		<?php
		while ( have_posts() ) : the_post();

      the_date();

			get_template_part( 'template-parts/content', get_post_format() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
    <div class="is-center-100"><?php get_sidebar(); ?></div>
	</div>
	</section>

	<?php get_footer(); ?>
