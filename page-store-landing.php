<?php
/**
 * Template Name: Store Landing Page
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
<div class="section banner store">

	<?php
		echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';

					$i = 0;

					if( have_rows('store_banners',18) ):
						while ( have_rows('store_banners',18) ) : the_row();

							$image = get_sub_field('image',18);
							$link = get_sub_field('link',18);
							$new_window = get_sub_field('new_window',18);
							$text_overlay = get_sub_field('text_overlay',18);
							$add_button = get_sub_field('add_button',18);
							$button_text = get_sub_field('button_text',18);
							$button_link = get_sub_field('button_link',18);

							if($new_window){
								$target = 'target="_blank"';
							} else {
								$target = '';
							}

							if($link){
								echo '<div class="swiper-slide">';
									if($text_overlay){
										echo '<div class="slide-text">';
											echo $text_overlay;
											if($add_button){
												echo '<div class="button"><a href="'.$button_link.'">'.$button_text.'</a></div>';
											}
										echo '</div>';
									}
									echo '<a href="'.$link.'" '.$target.'><img src="'.$image['url'].'" id="hbImg'.$i.'" /></a>';
								echo '</div>';
							} else {
								echo '<div class="swiper-slide">';
									if($text_overlay){
										echo '<div class="slide-text">';
											echo $text_overlay;
											if($add_button){
												echo '<div class="button"><a href="'.$button_link.'">'.$button_text.'</a></div>';
											}
										echo '</div>';
									}
									echo '<img src="'.$image['url'].'" id="hbImg'.$i.'" />';
								echo '</div>';
							}

							$i++;

						endwhile;

					endif;

			echo '</div>';
		echo '</div>';
	?>

	<div class="bannerBtns"></div><!--end .bannerBtns-->

	<?php if ($i > 1){ ?>
	<script>
		$(document).ready(function(){
			banner = new Swiper('.banner .swiper-container', {
				pagination: '.banner .bannerBtns',
				paginationClickable: true,
				loopAdditionalSlides:3,
				loop: true
			});
		});
	</script>
	<?php } ?>

</div><!--end .section-->

<div class="section storeItems">
	<div class="heading">
		<a href="/store/featured-products/">View All</a>
		<h1>Featured Products</h1>
	</div><!--end .heading-->
	<div class="products productsFeatured">
		<div class="arrowLeft"></div>
		<div class="arrowRight"></div>
		<?php

			echo '<div class="swiper-container">';
				echo '<div class="swiper-wrapper">';

					$args = array(
						'post_type' => 'product',
						'meta_key' => '_featured',
						'meta_value' => 'yes',
						'posts_per_page' => 10
					);

					$featured_query = new WP_Query($args);

					if ($featured_query->have_posts()) :
						while ($featured_query->have_posts()) :
							$featured_query->the_post();

							$product = new WC_Product(get_the_ID());
							$thumbnail = woocommerce_get_product_thumbnail('shop_catalog');
							$price_html = $product->get_price_html();
							$link = get_the_permalink(get_the_ID());

							echo '<div class="swiper-slide">';
								echo '<div class="product">';
									echo '<a href="'.$link.'">';
										echo '<span class="img">';
											echo $thumbnail;
											//echo '<img src="'. get_template_directory_uri() .'/images/store-product-1.png" />';
										echo '</span><!--end .img-->';
										echo '<span class="price">';
											echo 'Price<span>'.$price_html.'</span>';
										echo '</span><!--end .price-->';
										echo '<span class="txt">';
											echo '<h4>'.$product->post->post_title.'</h4>';
										echo '</span><!--end .txt-->';
									echo '</a>';
								echo '</div><!--end .product-->';
							echo '</div>';

						endwhile;

					endif;

					wp_reset_query(); // Remember to reset


				echo '</div>';
			echo '</div>';

		?>
	</div><!--end .products-->

	<script>
		$(document).ready(function(){
			items = new Swiper('.productsFeatured .swiper-container', {
				nextButton: '.productsFeatured .arrowRight',
				prevButton: '.productsFeatured .arrowLeft',
				slidesPerView: 1,
				slidesPerGroup: 1,
				paginationClickable: true
			});

			var snap_max = true;
			var snap_1100 = true;
			var snap_900 = true;

			getSizeSwiper();

			function getSizeSwiper() {
				var width = $('.container').width();

				if(width >= 1100){
					if(snap_max){
						snap_max = false;
						if (items){
							items.destroy(true, true);
							items = new Swiper('.productsFeatured .swiper-container', {
								nextButton: '.productsFeatured .arrowRight',
								prevButton: '.productsFeatured .arrowLeft',
								slidesPerView: 4,
								slidesPerGroup: 4,
								paginationClickable: true,
								spaceBetween: 18
							});
							snap_1100 = true;
							snap_900 = true;
						}
					}
				} else if(width < 1100 && width >= 550) {
					if(snap_1100){
						snap_1100 = false;
						if (items){
							items.destroy(true, true);
							items = new Swiper('.productsFeatured .swiper-container', {
								nextButton: '.productsFeatured .arrowRight',
								prevButton: '.productsFeatured .arrowLeft',
								slidesPerView: 2,
								slidesPerGroup: 2,
								paginationClickable: true,
								spaceBetween: 10
							});
							snap_max = true;
							snap_900 = true;
						}
					}
				} else if(width < 550) {
					if(snap_900){
						snap_900 = false;
						if (items){
							items.destroy(true, true);
							items = new Swiper('.productsFeatured .swiper-container', {
								nextButton: '.productsFeatured .arrowRight',
								prevButton: '.productsFeatured .arrowLeft',
								slidesPerView: 1,
								slidesPerGroup: 1,
								paginationClickable: true
							});
							snap_max = true;
							snap_1100 = true;
						}
					}
				}
			}

			$(window).resize(function(){
				getSizeSwiper();
			});

		});
	</script>

</div><!--end .section-->

<div class="section storeItems gray">
	<div class="heading">
		<a href="/product-category/best-selling/">View All</a>
		<h1>Best Selling</h1>
	</div><!--end .heading-->
	<div class="products productsCategory1">
		<div class="arrowLeft"></div>
		<div class="arrowRight"></div>
		<?php

			echo '<div class="swiper-container">';
				echo '<div class="swiper-wrapper">';

					$args = array(
						'post_type' => 'product',
						'meta_key' => 'total_sales',
						'orderby' => 'meta_value_num',
						'tax_query'	=> array(
							array(
								'taxonomy'  => 'product_cat',
								'field'     => 'slug',
								'terms'     => 'giving',
								'operator'  => 'NOT IN')
							),
						'posts_per_page' => 10
					);

					$cat_unitedstates_query = new WP_Query($args);

					if ($cat_unitedstates_query->have_posts()) :
						while ($cat_unitedstates_query->have_posts()) :
							$cat_unitedstates_query->the_post();

							$product = new WC_Product(get_the_ID());
							$thumbnail = woocommerce_get_product_thumbnail('shop_catalog');
							$price_html = $product->get_price_html();
							$link = get_the_permalink(get_the_ID());

							echo '<div class="swiper-slide">';
								echo '<div class="product">';
									echo '<a href="'.$link.'">';
										echo '<span class="img">';
											echo $thumbnail;
											//echo '<img src="'. get_template_directory_uri() .'/images/store-product-1.png" />';
										echo '</span><!--end .img-->';
										echo '<span class="price">';
											echo 'Price<span>'.$price_html.'</span>';
										echo '</span><!--end .price-->';
										echo '<span class="txt">';
											echo '<h4>'.$product->post->post_title.'</h4>';
										echo '</span><!--end .txt-->';
									echo '</a>';
								echo '</div><!--end .product-->';
							echo '</div>';

						endwhile;
					endif;

				echo '</div>';
			echo '</div>';

		?>
	</div><!--end .products-->

	<script>
		$(document).ready(function(){
			items2 = new Swiper('.productsCategory1 .swiper-container', {
				nextButton: '.productsCategory1 .arrowRight',
				prevButton: '.productsCategory1 .arrowLeft',
				slidesPerView: 1,
				slidesPerGroup: 1,
				paginationClickable: true
			});

			var snap_max_c = true;
			var snap_1100_c = true;
			var snap_900_c = true;

			getSizeSwiper2();

			function getSizeSwiper2() {
				var width2 = $('.container').width();

				if(width2 >= 1100){
					if(snap_max_c){
						snap_max_c = false;
						if (items2){
							items2.destroy(true, true);
							items2 = new Swiper('.productsCategory1 .swiper-container', {
								nextButton: '.productsCategory1 .arrowRight',
								prevButton: '.productsCategory1 .arrowLeft',
								slidesPerView: 4,
								slidesPerGroup: 4,
								paginationClickable: true,
								spaceBetween: 18
							});
							snap_1100_c = true;
							snap_900_c = true;
						}
					}
				} else if(width2 < 1100 && width2 >= 550) {
					if(snap_1100_c){
						snap_1100_c = false;
						if (items2){
							items2.destroy(true, true);
							items2 = new Swiper('.productsCategory1 .swiper-container', {
								nextButton: '.productsCategory1 .arrowRight',
								prevButton: '.productsCategory1 .arrowLeft',
								slidesPerView: 2,
								slidesPerGroup: 2,
								paginationClickable: true,
								spaceBetween: 10
							});
							snap_max_c = true;
							snap_900_c = true;
						}
					}
				} else if(width2 < 550) {
					if(snap_900_c){
						snap_900_c = false;
						if (items2){
							items2.destroy(true, true);
							items2 = new Swiper('.productsCategory1 .swiper-container', {
								nextButton: '.productsCategory1 .arrowRight',
								prevButton: '.productsCategory1 .arrowLeft',
								slidesPerView: 1,
								slidesPerGroup: 1,
								paginationClickable: true
							});
							snap_max_c = true;
							snap_1100_c = true;
						}
					}
				}
			}

			$(window).resize(function(){
				getSizeSwiper2();
			});

		});
	</script>

	</div><!--end .products-->
</div><!--end .section-->

<!--<div class="section storeItems">
	<div class="heading">
		<a href="/product-category/missing-jesus/">View All</a>
		<h1>Missing Jesus</h1>
	</div>
	<div class="products productsCategory2">
		<div class="arrowLeft"></div>
		<div class="arrowRight"></div>
		<?php

			/*echo '<div class="swiper-container">';
				echo '<div class="swiper-wrapper">';

					$args = array(
						'post_type' => 'product',
						'tax_query' => array(
							array ('taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => 'missing-jesus'
								 )
							 ),
						'posts_per_page' => 10
					);

					$cat_canada_query = new WP_Query($args);

					if ($cat_canada_query->have_posts()) :
						while ($cat_canada_query->have_posts()) :
							$cat_canada_query->the_post();

							$product = new WC_Product(get_the_ID());
							$thumbnail = woocommerce_get_product_thumbnail('shop_single');
							$price_html = $product->get_price_html();
							$link = get_the_permalink(get_the_ID());

							echo '<div class="swiper-slide">';
								echo '<div class="product">';
									echo '<a href="'.$link.'">';
										echo '<span class="img">';
											echo $thumbnail;
											//echo '<img src="'. get_template_directory_uri() .'/images/store-product-1.png" />';
										echo '</span>';
										echo '<span class="price">';
											echo 'Price<span>'.$price_html.'</span>';
										echo '</span>';
										echo '<span class="txt">';
											echo '<h4>'.$product->post->post_title.'</h4>';
											echo 'Etiam accumsan';
										echo '</span>';
									echo '</a>';
								echo '</div>';
							echo '</div>';

						endwhile;
					endif;

				echo '</div>';
			echo '</div>';*/

		?>
	</div>

	<script>
		$(document).ready(function(){
			items = new Swiper('.productsCategory2 .swiper-container', {
				nextButton: '.productsCategory2 .arrowRight',
				prevButton: '.productsCategory2 .arrowLeft',
				slidesPerView: 4,
				paginationClickable: true,
				loopAdditionalSlides:3,
				spaceBetween: 18,
			});
		});
	</script>
</div>-->
<?php wp_reset_query(); ?>
<?php get_footer( 'shop' ); ?>
