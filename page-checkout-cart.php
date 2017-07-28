<?php
/**
 * Template Name: Checkout/Cart Page
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

get_header(); ?>

		<?php while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'title' );  ?>
			<div class="section give form2">
				<?php $subtitle = get_field('banner_subtitle'); ?>

					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php if($subtitle){
						echo '<h3>'.$subtitle.'</h3>';
					}?>
					<hr />

					<?php the_content(); ?>

			</div><!--end .section-->

		<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
