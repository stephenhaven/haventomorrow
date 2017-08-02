<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php get_sidebar('banner'); ?>

<?php get_sidebar('store-search'); ?>

<div class="section storeItems results">
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
	
	<div class="heading searchFilters">
		<span class="txt">Sort by</span>
		<div class="filter">
			<span class="arrow">icon</span>
			<?php 
				$queryString = $_SERVER['QUERY_STRING'];
				$orderby = $_GET["orderby"];
				
				if($orderby == 'popularity'){
					echo '<span class="current">Popularity</span>';
				} else if($orderby == 'date'){
					echo '<span class="current">Newness</span>';
				} else if($orderby == 'price'){
					echo '<span class="current">Low to High</span>';
				} else if($orderby == 'price-desc'){
					echo '<span class="current">High To Low</span>';
				} else {
					echo '<span class="current">All Products</span>';
				}					
			?>
			<ul>
			<?php 
							
				if ($queryString){
					echo '<li><a href="?'.$queryString.'&orderby=popularity">Popularity</a></li>';
					echo '<li><a href="?'.$queryString.'&orderby=date">Newness</a></li>';
					echo '<li><a href="?'.$queryString.'&orderby=price">Low to High</a></li>';
					echo '<li><a href="?'.$queryString.'&orderby=price-desc">High To Low</a></li>';
				} else {
					echo '<li><a href="?orderby=popularity">Popularity</a></li>';
					echo '<li><a href="?orderby=date">Newness</a></li>';
					echo '<li><a href="?orderby=price">Low to High</a></li>';
					echo '<li><a href="?orderby=price-desc">High To Low</a></li>';
				}
			
			?>				
			</ul>
		</div><!--end .filter-->
		
		<?php
			/**
			 * woocommerce_before_shop_loop hook
			 *
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
		?>
	</div><!--end .heading-->
		
		<div class="products">
			<?php woocommerce_product_subcategories(); ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
					<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>
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

</div><!--end .section-->
<?php
	/**
	 * woocommerce_sidebar hook
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );
?>
<?php get_footer( 'shop' ); ?>
