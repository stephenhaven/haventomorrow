<?php

get_header();

	// get_sidebar('banner');
  // get_template_part( 'template-parts/content', 'title' );  ?>

  <section class="c-padding-180 dark" style="background-image:url('http://www.haventoday.ca/wp-content/themes/haven2015/images/header-program.jpg')">
    <div class="container">
      <h1 class="is-center">Program</h1>
    </div>
  </section>

  <?php

		global $USAProduct;
		global $CanadaProduct;

		$seriesName = get_queried_object()->slug;

		//var_dump($seriesName);

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

				if ($countposts == 0){

					$displayedSeries = $program_series[0];
					$currentSeries = $program_series[0]->name;
					echo '<div class="section programs">';
					echo '<h1>' . $program_series[0]->name . '</h1>';
					echo '<hr />';
					echo '<div class="content">';
					echo '<div class="left">';
					echo '<h2>' . $program_title . '</h2>';
					echo '<img id="btnProgramImage" src="' . $program_image['url'] . '" data-playing="0" data-username="haven" data-podcast="' . $event . '" />';
					echo '<div style="color:#fff;">' . $program_desc . '</div>';
					echo '</div><!--end .left-->';
					echo '<div class="right">';
				}
				if ($currentSeries == $program_series[0]->name && $stillInSeries){
					get_template_part( 'template-parts/content', 'programs' );
				}
				else {
					$stillInSeries = false;
				}
				$currentSeries == $program_series[0]->name;
				$countposts++;
			}
			echo '</div><!--end .right-->';
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

<?php
		$program_series2 = get_the_terms($thisPostID,'series');
		if( !empty($program_series2) ) {
			$program_series2 = array_pop($program_series2);
			$tmpBlogPosts = get_field('program_blog_post', $program_series2 );
			$USAProduct = get_field('program_product_united_states', $program_series2 );
			$CanadaProduct = get_field('program_product_canada', $program_series2 );

			if ($_COOKIE["country"] == 'CA'){
				$relatedProducts = $CanadaProduct;
			} else {
				$relatedProducts = $USAProduct;
			}

			if (!empty($relatedProducts)){

				echo '<div class="section program1">';
				echo '<h1>Resource</h1>';
				echo '<hr class="blue" />';

				foreach ($relatedProducts as $product) {

					$wcProduct = wc_get_product( $product->ID );
					$productURL = str_replace(">"," style=\"width:25%;\">",$wcProduct->get_image('shop_catalog'));
					$productPermalink = get_permalink($product->ID);

					//Series Product
					echo '<div class="full seriesProduct">';
					echo '<div class="info">';
					echo '<h1>' . $wcProduct->post->post_title . '</h1>';
					//echo '<h2>Is our "thank you" for your gift to Haven.</h2>';
					//echo '<h2>We simply ask that you be as generous as you can and give as unto the Lord. Thank you!</h2>';
					echo '<p>' . $wcProduct->post->post_excerpt . '</p>';
					echo '<a href="' . $productPermalink . '" class="o-button">Get this Resource</a>';
					echo '</div><!--end .info-->';
					echo '<div class="inner">';
					echo $productURL;
					echo '</div><!--end .inner-->';
					//mobile
					echo '<div class="info mobile" style="color:black; display:none;">';
					echo '<h1>' . $wcProduct->post->post_title . '</h1>';
					//echo '<h2>Is our "thank you" for your gift to Haven.</h2>';
					//echo '<h2>We simply ask that you be as generous as you can and give as unto the Lord. Thank you!</h2>';
					echo '<p>' . $wcProduct->post->post_excerpt . '</p>';
					echo '<a href="' . $productPermalink . '" class="o-button">Get this Resource</a>';
					echo '</div><!--end .info-->';
					echo '</div><!--end .full-->';

				}

				echo '</div><!--end .section-->';

			}


			//Series Video
			$vidLink = get_field('program_video', $program_series2);
			$vidDesc = get_field('program_video_description', $program_series2);

			if ($vidLink) {
				echo '<div class="section program2">';
				echo '<h1>Video</h1>';
				echo '<hr class="blue" />';

				$vidParse = parse_url($vidLink);
				$vidHost = $vidParse['host'];
				$vidID = $vidParse['path'];
				if ($vidHost == 'youtube.com' || $vidHost == 'www.youtube.com' || $vidHost == 'youtu.be' || $vidHost == 'www.youtu.be') {
					if ($vidID == '/watch') {
						$vidID = $vidParse['query'];
						$vidID = str_replace('v=','/',$vidID);
					}
					echo '<iframe width="904" height="505" src="https://www.youtube.com/embed' . $vidID . '" frameborder="0" allowfullscreen></iframe>';
				} else if ($vidHost == 'vimeo.com') {
					echo '<iframe src="https://player.vimeo.com/video' . $vidID . '" width="904" height="505" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
				} else {
					echo '<iframe src="' . $vidLink . '" width="904" height="505" frameborder="0" allowfullscreen></iframe>';
				}

				echo '<div class="content">';
				echo $vidDesc;
				echo '</div><!--end .content-->';
				echo '</div><!--end .section-->';
			}

			//var_dump('GWERE 45 - ' . $tmpBlogPosts.length);
			//var_dump($tmpBlogPosts);
			//die();

			if ($tmpBlogPosts != null){
				echo '<div class="section program1">';
				echo '<h1>Blog</h1>';
				echo '<hr class="blue" />';
				foreach($tmpBlogPosts as $blogPost){
					$blogFeatImage = wp_get_attachment_url( get_post_thumbnail_id($blogPost->ID));
					if ($blogFeatImage) {
						echo '<div class="content">';
						echo '<div class="left">';
						echo '<img src="' . $blogFeatImage . '" />';
						echo '</div><!--end .left-->';
						echo '<div class="right">';
						echo '<h2>' . $blogPost->post_title . '</h2>';
						echo '<p>' . substr($blogPost->post_content,0,200) . ' ...</p>';
						echo '<a href="' . $blogPost->guid . '" class="outlineBtn">Read More</a>';
						echo '</div><!--end .right-->';
					} else {
						echo '<div class="full">';
						echo '<h2>' . $blogPost->post_title . '</h2>';
						echo '<p>' . substr($blogPost->post_content,0,200) . ' ...</p>';
						echo '<a href="' . $blogPost->guid . '" class="outlineBtn">Read More</a>';
						echo '</div><!--end .full-->';
					}
					echo '</div><!--end .content-->';
				}
				echo '</div><!--end .section-->';
			}
		}

		?>


		<div class="section archive">
			<div class="content">
				<input type="text" placeholder="search haven" id="textSearch"/>
				<input type="button" value="Search" id="btnSearchArchive"/>
				<div class="filters" id="archiveFilters">
					Search by:
					<div class="filter" id="archiveFilter">
						<span class="arrow">icon</span>
						<span class="current">Filters</span>
						<ul>
							<li data-slug="category" data-name="Category"><a href="javascript:;">Category</a></li>
							<li data-slug="series" data-name="Series"><a href="javascript:;">Series</a></li>
							<li data-slug="guest" data-name="Guest"><a href="javascript:;">Guest</a></li>
							<li data-slug="date" data-name="Date"><a href="javascript:;">Date</a></li>
						</ul>
					</div><!--end .filter-->
				</div><!--end .filters-->
			</div>
			<div class="items" style="display: none;">
				<div class="arrowLeft"><span>previous</span></div>
				<div class="arrowRight"><span>next</span></div>
				<div class="inner">
				</div><!--end .inner-->
			</div><!--end .items-->
		</div><!--end .section-->

		<?php //get_template_part( 'content', get_post_format() ); ?>

<?php get_footer(); ?>
