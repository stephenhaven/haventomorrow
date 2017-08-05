<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

	$args_haven = array(
		'post_type' => 'haven',
		'posts_per_page' => 1,
		'post_status' => 'publish'
	);

	$query_haven = new WP_Query( $args_haven );

	if ( $query_haven->have_posts() ) {
		while ( $query_haven->have_posts() ) {
			$query_haven->the_post();

			$haven_title = get_the_title();
			$haven_description = get_the_content();
			$haven_permalink = get_the_permalink();
			$haven_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');

			$hn_audio_file = get_field('hn_audio_file');
			$hn_audio_description = get_field('hn_audio_description');

			$haven_image_url = $haven_image[0];
			if($haven_image_url == ''){
				$haven_image_url = '/wp-content/themes/haventomorrow/assets/img/missing.png';
			}

			echo '<h1>Haven Now</h1>';
			echo '<hr class="blue" />';
			echo '<div class="content">';
				echo '<div class="image" style="background:url('.$haven_image_url.') center center no-repeat; background-size:cover;"><a href="'.$haven_permalink.'">Haven Now</a></div>';
				echo '<h2>'.$haven_title.'</h2>';
				echo '<p>'.strip_tags(pjs_truncate($haven_description,200), '<br>').'</p>';
				if($hn_audio_file){
					echo '<a href="'.$haven_permalink.'" class="outlineBtn">Listen</a>';
				}
				echo '<a href="'.$haven_permalink.'" class="outlineBtn">More</a>';
			echo '</div><!--end .content-->';

		}
	}

	wp_reset_postdata();

?>
