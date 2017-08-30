<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$featuredProductsID = get_the_ID();

if ($product->donation == false && $product->product_type != 'composite' && $product->product_type != 'variable' && $product_is_nyp == 0 && $featuredProductsID != 150) {

	if ( empty( $product ) || ! $product->exists() ) {
		return;
	}

	//pull related products
	//$related = $product->get_related( $posts_per_page );

	//if ( sizeof( $related ) == 0 ) return;

	/*$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => $posts_per_page,
		'orderby'              => $orderby,
		'post__in'             => $related,
		'post__not_in'         => array( $product->id )
	) );*/

	//pull featured products
	$args = array(
		'post_type' => 'product',
		'meta_key' => '_featured',
		'meta_value' => 'yes',
		'posts_per_page' => 10
	);

	$products = new WP_Query( $args );

	$woocommerce_loop['columns'] = $columns;

	if ( $products->have_posts() ) :

	?>

		<div class="section storeItems">
		<div class="heading">
			<!--<a href="/store/featured-products/">View All</a>-->
			<h1>Featured Products</h1>
		</div><!--end .heading-->
		<div class="products productsCategory2">
			<div class="arrowLeft"></div>
			<div class="arrowRight"></div>
				<div class="swiper-container">
				<div class="swiper-wrapper">

					<?php //woocommerce_product_loop_start(); ?>

						<?php while ( $products->have_posts() ) : $products->the_post(); ?>
							<div class="swiper-slide">
							<?php wc_get_template_part( 'content', 'product-swiper-featured' ); ?>
							</div>
						<?php endwhile; // end of the loop. ?>

					<?php //woocommerce_product_loop_end(); ?>
				</div>
				</div>

		</div><!--end .products-->

		<script>
			$(document).ready(function(){
				items = new Swiper('.productsCategory2 .swiper-container', {
					nextButton: '.productsCategory2 .arrowRight',
					prevButton: '.productsCategory2 .arrowLeft',
					slidesPerView: 4,
					paginationClickable: true,
					spaceBetween: 18,
				});
			});
		</script>
	</div><!--end .section-->

	<?php endif;

	wp_reset_postdata();

}
