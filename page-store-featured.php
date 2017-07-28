<?php
/**
 * Template Name: Store Featured Products Page
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

get_template_part( 'template-parts/content', 'title' );  ?>

<?php get_sidebar('store-search'); ?>

<div class="section storeItems results">
	<br />
	<?php
		/**
		 * woocommerce_archive_description hook
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	?>

		<?php if ( have_posts() ) : ?>
		<?php
			/**
			 * woocommerce_before_shop_loop hook
			 *
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
		?>

		<div class="products">
			<?php woocommerce_product_subcategories(); ?>

			<?php

			$args = array(
				'post_type' => 'product',
				'meta_key' => '_featured',
				'meta_value' => 'yes',
				'posts_per_page' => -1
			);

			$featured_query = new WP_Query($args);

			if ($featured_query->have_posts()) :
				while ($featured_query->have_posts()) :
					$featured_query->the_post();

					wc_get_template_part( 'content', 'product' );

				endwhile; // end of the loop.
			endif;
			?>
		</div>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		//do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

</div><!--end .section-->

<?php get_footer( 'shop' ); ?>
