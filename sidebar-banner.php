<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */
?>
<div class="banner sub">
	<?php
		$product = get_product(get_the_id());
		$product_categories = $product->get_categories();

		$directory_url = get_template_directory_uri();
		$title = get_the_title();

		if (is_404()) {
			echo '<img src="http://www.haventoday.org/wp-content/uploads/2016/02/header-404-1.jpg" />';
			echo '<div class="title">Not Found<hr /></div>';
		} else if(is_search()){
			echo '<img src="' . $directory_url . '/images/header-about.jpg" />';
			echo '<div class="title">Search<hr /></div>';
		} else if('programs' == get_post_type() || 'series' == get_post_type() || 'program' == get_post_type()){
			echo '<img src="' . $directory_url . '/images/header-program.jpg" />';
			echo '<div class="title">Program<hr /></div>';
		} else if('anchor' == get_post_type()){
			echo '<img src="' . $directory_url . '/images/header-program.jpg" />';
			echo '<div class="title">Anchor<hr /></div>';
		} else if('haven' == get_post_type()){
			echo '<img src="' . $directory_url . '/images/header-program.jpg" />';
			echo '<div class="title">Haven Now<hr /></div>';
		} else if('anchortoday' == get_post_type()){
			echo '<img src="' . $directory_url . '/images/header-program.jpg" />';
			echo '<div class="title">Anchor Today<hr /></div>';
		} else if(is_woocommerce() || is_product() || is_product_category() || is_shop() || is_page(18)){
			if (strpos($product_categories, 'Giving') !== false) {
				echo '<img src="' . $directory_url . '/images/header-giving.jpg" />';
				echo '<div class="title">Giving<hr /></div>';
			} else if ($product->product_type == 'variable'){
				echo '<img src="' . $directory_url . '/images/header-giving.jpg" />';
				echo '<div class="title">Giving<hr /></div>';
			} else {
				echo '<img src="http://www.haventoday.org/wp-content/uploads/2016/03/shutterstock_253232608_.jpg" />';
				if($_COOKIE['country'] == 'CA'){
					echo '<div class="title">Resources<hr /></div>';
				} else {
					echo '<div class="title">Store<hr /></div>';
				}
			}
		} else if (is_checkout() || is_cart()) {

			$banner_image = get_field('banner_image');
			$banner_text = get_field('banner_text');
			$page_title = get_the_title();

			if($banner_image){
				echo '<img src="' . $banner_image['url'] . '" />';
			} else {
				echo '<img src="' . $directory_url . '/images/header-about.jpg" />';
			}

			if($banner_text){
				echo '<div class="title">'.$banner_text.'<hr /></div>';
			} else {
				echo '<div class="title">'.$title.'<hr /></div>';
			}

		} else if(is_single() || is_home() && !is_404()){
			echo '<img src="' . $directory_url . '/images/header-program.jpg" />';
			echo '<div class="title">Blog<hr /></div>';
		} else {
			$banner_image = get_field('banner_image');
			$banner_text = get_field('banner_text');
			$page_title = get_the_title();

			if($banner_image) {
				echo '<img src="' . $banner_image['url'] . '" />';
			} else {
				echo '<img src="http://www.haventoday.org/wp-content/uploads/2016/03/shutterstock_222422662_.jpg" />';
			}

			if (is_archive() || is_category() || is_author() || is_tag()) {
				echo '<div class="title">Archive<hr /></div>';
			} else if ($banner_text){
				echo '<div class="title">'.$banner_text.'<hr /></div>';
			} else {
				echo '<div class="title">'.$title.'<hr /></div>';
			}
		}
	?>
</div><!--end .banner-->
