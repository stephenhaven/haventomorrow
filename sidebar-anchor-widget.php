<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

	$args_anchor = array(
		'post_type' => 'anchortoday',
		'posts_per_page' => 1,
		'post_status' => 'publish'
	);

	$query_anchor = new WP_Query( $args_anchor );

	if ( $query_anchor->have_posts() ) {
		while ( $query_anchor->have_posts() ) {
			$query_anchor->the_post();

			$anchor_title = get_the_title();
			$anchor_description = get_the_content();
			$anchor_permalink = get_the_permalink();
			$anchor_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');

			$at_audio_file = get_field('at_audio_file');
			$at_audio_description = get_field('at_audio_description');

			$anchor_image_url = $anchor_image[0];
			if($anchor_image_url == ''){
				$anchor_image_url = '/wp-content/themes/haventomorrow/assets/img/missing-anchortoday.png';
			}

			echo '<h1>Anchor Today</h1>';
			echo '<hr class="blue" />';
			echo '<div class="content">';
				echo '<div class="image" style="background:url('.$anchor_image_url.') center center no-repeat; background-size:cover;"><a href="'.$anchor_permalink.'">Anchor</a></div>';
				echo '<h2>'.$anchor_title.'</h2>';
				echo '<p>'.strip_tags(pjs_truncate($anchor_description,200), '<br>').'</p>';
				if($at_audio_file){
					echo '<a href="'.$anchor_permalink.'" class="outlineBtn">Listen</a>';
				}
				echo '<a href="'.$anchor_permalink.'" class="outlineBtn">More</a>';
			echo '</div><!--end .content-->';

			//echo '<div class="left" style="background:url('.$anchor_image['url'].') center center no-repeat; background-size:cover;"><a href="'.$anchor_permalink.'">Anchor</a>';

		}
	}

	wp_reset_postdata();

?>
