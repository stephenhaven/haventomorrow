<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */
global $country_name;
?>

<div class="section productScroll">
	<h1>Recent Products</h1>
	<div class="products">

	<?php

	$USAProduct = get_field('product_united_states', 8);
	$CanadaProduct = get_field('product_canada', 8);
	$count = 0;

	if ($country_name == 'Canada'){
		$relatedProducts = $CanadaProduct;
	} else {
		$relatedProducts = $USAProduct;
	}

	if (!empty($relatedProducts)){

		echo '<div class="swiper-button-prev"><span>Previous</span></div>';
		echo '<div class="swiper-button-next"><span>Next</span></div>';

		echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';

			foreach ($relatedProducts as $product) {

				$postid = url_to_postid($product['product_page_url']);

				$wcProduct = wc_get_product( $postid );
				$productURL = str_replace(">"," style=\"width:25%;\">",$wcProduct->get_image());
				$productPermalink = get_permalink($postid);

				if($country_name == 'Canada'){
					$productPermalink = $productPermalink . '?wcj-country=CAN';
				}

				echo '<div class="swiper-slide">';
					echo '<div class="product">';
						//echo '<a href="#hrefReadMore" data-url="' . $productPermalink . '">';
						echo '<a href="'.$productPermalink.'">';
							if (has_post_thumbnail( $wcProduct->post->ID )) echo get_the_post_thumbnail($wcProduct->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" />';
							echo '<span class="productTitle">' . $wcProduct->post->post_title . '</span>';
							echo '<span><span>View Product</span></span>';
						echo '</a>';
					echo '</div><!--end .product-->';
				echo '</div>';
				$count++;

			}

			echo '</div>';
		echo '</div>';

	}

			/*$args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => 10, 'orderby' =>'date', 'order' => 'DESC', 'meta_key' => '_virtual', 'meta_value' => 'no', 'meta_compare' => '=');
            $loop = new WP_Query( $args );
			$count = 0;
            while ( $loop->have_posts() ) : $loop->the_post(); global $product;

					echo '<div class="swiper-slide">';
						echo '<div class="product">';
							echo '<a href="#hrefReadMore" data-url="' . get_the_permalink() . '">';
								if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" />';
								echo '<span class="productTitle">' . get_the_title() . '</span>';
								echo '<span><span>View Product</span></span>';
							echo '</a>';
						echo '</div><!--end .product-->';
					echo '</div>';
					$count++;

			endwhile;
			wp_reset_query();*/

	?>

	</div><!--end .products-->
</div><!--end .section-->

<script>
$(document).ready(function(){

	products = new Swiper('.products .swiper-container', {
		nextButton: '.products .swiper-button-next',
		prevButton: '.products .swiper-button-prev',
        centeredSlides: true,
		width: 338,
        paginationClickable: true,
		loop: true,
		slidesPerView: 'auto',
		loopedSlides: <?php echo $count; ?>
    });

	$('a[href="#hrefReadMore"]').click(function() {
		redirectProductCountry($(this).data('url'))
	});

});
</script>
