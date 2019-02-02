<?php

get_header();
get_template_part( 'template-parts/content', 'series-title' ); ?>

  <?php

		global $USAProduct;
		global $CanadaProduct;

		$seriesName = get_field('current_series_name', 'option');


		$args_programs = array(
			'post_type' => 'programs',
			//'search_prod_title' => $search_term,
			'post_status' => array('publish'),
			'posts_per_page' => 5,
			'orderby' => 'date',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'series',
					'field'    => 'slug',
					'terms'    => strtolower($seriesName)
				)
			)
		);

		//add_filter( 'posts_where', 'title_filter', 10, 2 );
		$query_programs = new WP_Query( $args_programs );
		//remove_filter( 'posts_where', 'title_filter', 10, 2 );

		//var_dump($query_programs);
		//die();

		$tile_array = array();
		if ( $query_programs->have_posts() ) {
			$currentSeries = "";
			$stillInSeries = true;
			$countposts = 0;
			$thisPostID = 0;

			while ( $query_programs->have_posts() ) {
				$query_programs->the_post();
				if ($thisPostID == 0){
					$thisPostID = get_the_id();
				}
				$program_title = get_field('program_title');
				$program_series = get_the_terms(get_the_id(),'series');
				$program_image = get_field('program_image');
				$program_desc = get_field('program_description');
				$program_date = get_the_date();
				date_default_timezone_set('America/Los_Angeles');
				$year = date("Y",strtotime($program_date));
				$month = date("m",strtotime($program_date));
				$day = date("d",strtotime($program_date));
				$event = mktime(00, 00, 00, $month, $day, $year);
				
				if ($countposts == 0) {
					
					$displayedSeries = $program_series[0];
					$currentSeries = $program_series[0]->name;
					echo '<div class="section programs">';
					echo '<h1>' . $program_series[0]->name . '</h1>';
					echo '<hr />';
					echo '<div class="content" style="max-width: 985px;">';
					echo '<div class="container"><div class="row">';
          			echo '<div class="col-md-12">';
					
					?>

					<div class="row">
						<div class="col-md-7">
							<img id="btnProgramImage" src="<?php echo $program_image['url'];?>" data-playing="0" data-username="haven" data-podcast="<?php echo $event;?>" style="margin-top: 0px;" />
							<div style="color:#fff;"><?php echo $program_desc;?></div>
						</div>
						<div class="col-md-5">
							
				<?php }
				
				if ($currentSeries == $program_series[0]->name && $stillInSeries){
					get_template_part( 'template-parts/content', 'programs' );
				} else {
					$stillInSeries = false;
				}
				
				$currentSeries == $program_series[0]->name;
				$countposts++;
				
			}
	?>
	</div></div>							
	<?php
      echo '</div><!--end .col-md-12-->';
      // echo '<div class="col-md-4">';
      // echo '</div><!--end .col-md-4-->';
      echo '</div></div><!--end .container-->';
			echo '</div><!--end .content-->';
			echo '<div class="socialShare">';
			echo '<h4>Share</h4><hr />';
			echo '<div class="addthis_toolbox"><div class="custom_images">';
			echo '<a class="addthis_button_facebook trans" addthis:url="' . get_the_permalink() . '" addthis:title="' . get_the_title() . '"><i class="fa fa-facebook"></i></a>';
			echo '<a class="addthis_button_twitter trans" addthis:url="' . get_the_permalink() . '" addthis:title="' . get_the_title() . '"><i class="fa fa-twitter"></i></a>';
			echo '<a class="addthis_button_email trans" addthis:url="' . get_the_permalink() . '" addthis:title="' . get_the_title() . '"><i class="fa fa-envelope"></i></a>';
			echo '</div></div></div><!--end .socialShare-->' . PHP_EOL;
			echo '</div><!--end .section-->';
		}

		wp_reset_postdata();
?>

<section class="c-padding-75 lookingForAnOlderProgramSection">
	<div class="center">
		<p class="lookingForOlderProgramP">Looking for an older program? <a href="/program-archive" target="_blank">Click here</a></p>
	</div>
</section>

<section class="c-padding-75 todaysOfferSection">
  <div class="container">
      <!-- <script id="subsplash-embed-fhxxb64" type="text/javascript">var target = document.getElementById("subsplash-embed-fhxxb64");var script = document.createElement("script");script.type = "text/javascript";script.onload = function() {subsplashEmbed("+07a8/lb/li/+fhxxb64?embed&branding", "https://subsplash.com/", "subsplash-embed-fhxxb64");};script.src = "https://dashboard.static.subsplash.com/production/web-client/external/embed-1.1.0.js";target.parentElement.insertBefore(script,target);</script> -->
      <hr class="todaysOfferLine" />
      <section class="c-padding-50">
        <div class="container">
          <div class="slider-premium">
          <?php
              if( have_rows('featured_product_slider', 'option') ):

                // loop through the rows of data
                  while ( have_rows('featured_product_slider', 'option') ) : the_row();

                      // display a sub field value
                      $label = get_sub_field('label', 'option');
                      $premium = get_sub_field('premium', 'option');
                      $desc = get_sub_field('brief_description', 'option');
                      $img = get_sub_field('premium_image', 'option');
                      $link = get_sub_field('premium_link', 'option');
                  ?>

                  <div>
                    <div class="row">
                    <div class="col-md-4">
                      <div class="">
                        <?php if( $label ): ?>
                        <h3><?php echo $label; ?></h3>
                        <?php endif; ?>
                        <?php if( $premium ): ?>
                        <h4><?php echo $premium; ?></h4>
                        <?php endif; ?>
                        <?php if( $desc ): ?>
                        <p><?php echo $desc; ?></p>
                        <?php endif; ?>
                    </div>
                    </div>
                    <div class="col-md-4 text-center">
                      <?php if( $link ): ?>
                      <?php if( $img ): ?>
                      <a href="<?php echo $link; ?>"><img src="<?php echo $img; ?>" width="80%"></a>
                      <?php endif; ?>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-4 text-center">
                      <div class="v-middle-absolute">
                        <?php if( $link ): ?>
                      <a href="<?php echo $link; ?>" class="o-button">GET THIS RESOURCE</a>
                      <?php endif; ?>
                    </div>
                    </div>
                  </div>
                  </div>

          <?php endwhile; ?>

        </div>

        <?php endif; ?>
      </div>
      </section>
  </div>
</section>
<script>
  $(document).ready(function(){
    $('.slider-premium').slick({});
  });
</script>

<section class="c-padding-25-100 blog light-2">
	<div class="container">
		<!-- FEATURED BLOG POST -->
		<div class="row">
			<div class="col-md-12" class="featuredBlogPostContainer">
				<div class="blogPostFeaturedContainer">
					<img src="/wp-content/uploads/2017/10/Blogpost_color.png" class="blogPostFeaturedImage" />
				</div>
				<h3 class="featuredPostSectionTitle">FEATURED BLOG POST</h3>

				<?php $featuredPost = get_field('current_series_featured_blog_post', 'option'); ?>

				<p class="featuredPostTitle" style="margin-bottom: 2px;"><strong><?php echo get_the_title($featuredPost); ?></strong></p>
				<p class="featuredPostDate"><em><?php echo get_the_date('F jS Y', $featuredPost); ?></em></p>
				<p class="featuredPostBody"><?php echo empty($featuredPost->post_excerpt) ? wp_trim_words($featuredPost->post_content, 55, '...') : $featuredPost->post_excerpt; ?></p>
				<div class="featuredPostKeepReadingContainer">
					<a class="o-button" href="<?php echo get_the_permalink($featuredPost); ?>">Keep Reading</a>
				</div>
			</div>
		</div>
		<!-- SEPARATION LINE -->
		<div class="row middleSeparationRow">
			<div class="col-md-12">
				<hr />
			</div>
		</div>
		<!-- RELATED SERIES -->
		<div class="row">
			<div class="col-md-12">
				<div class="blogPostFeaturedContainer">
					<img src="/wp-content/uploads/2017/10/Blogpost_color.png" class="blogPostFeaturedImage" />
				</div>
				<h3 class="featuredPostSectionTitle">RELATED SERIES</h3>
				<?php $relatedSeries = get_field('current_series_related_series', 'option'); ?>
				<p class="featuredPostTitle" style="margin-bottom: 2px;"><strong><?php echo $relatedSeries->name; ?></strong></p>
				<p class="featuredPostDate"><em><?php echo get_field('date', $relatedSeries->taxonomy.'_'.$relatedSeries->term_id); ?></em></p>
				<p class="featuredPostBody"><?php echo $relatedSeries->description; ?></p>
				<div class="featuredPostKeepReadingContainer">
					<a class="o-button" href="<?php echo get_term_link($relatedSeries); ?>">Keep Reading</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
