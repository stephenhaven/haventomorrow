<?php
/**
 * Template Name: Haven Now
 */

$hn_audio_file = get_field('hn_audio_file');
$hn_audio_description = get_field('hn_audio_description');

get_header();
get_template_part( 'template-parts/content', 'title' ); ?>
<section class="c-padding-75">
  <div class="container">
    <?php
    $haven_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
    $haven_image_url = $haven_image[0];
    if($haven_image_url){
    	echo '<div class="content-image">';
    	echo '<img src="'.$haven_image_url.'"/>';
    	echo '</div>';
    }

    if($hn_audio_file){
    	echo '<div class="content-audio">';
    	echo do_shortcode('[audio mp3="'.$hn_audio_file.'"][/audio]');
    	echo '<br />';
    	echo '<i>'.$hn_audio_description.'</i>';
    	echo '</div>';
    }
    ?>
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
