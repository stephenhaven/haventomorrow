<?php
/**
 * Template Name: Visual Composer Template
 */

get_header();
get_template_part( 'template-parts/content', 'title' ); ?>

<section class="c-padding-75">
  <div class="container">
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

<?php get_footer(); ?>
