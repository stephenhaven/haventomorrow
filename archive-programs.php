<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

get_header();

	// get_sidebar('banner');
	get_template_part( 'template-parts/content', 'title' );  ?>

	<?php
		$today = date("F j, Y");
		$args_programs = array(
			'post_type' => 'programs',
			'post_status' => array('publish'),
			'date_query' => array(
				array(
					'after' => $today,
					'inclusive' => true,
				),
			),
			'posts_per_page' => 5,
			'orderby' => 'date',
			'order' => 'ASC'
		);

		$query_programs = new WP_Query( $args_programs );

		if ( $query_programs->have_posts() ) {
			$currentSeries = "";
			$stillInSeries = true;
			$countposts = 0;
			while ( $query_programs->have_posts() ) {
				$query_programs->the_post();
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
				//var_dump($program_series);
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
					get_template_part( 'content', 'programs' );
				}
				else {
					$stillInSeries = false;
				}
				$currentSeries == $program_series[0]->name;
				$countposts++;
			}
			echo '</div><!--end .right-->';
			echo '</div><!--end .content-->';
			echo '<a href="' . get_term_link($displayedSeries,'series') . '" class="outlineBtn white">More About This Series</a>';
			echo '</div><!--end .section-->';
		}

		//$program_series2 = get_the_terms($thisPostID,'series');
		$program_series2 = $program_series[0];
		if( !empty($program_series2) ) {
			//$program_series2 = array_pop($program_series2);
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
				echo '<h1>Product</h1>';
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
					echo '<a href="' . $productPermalink . '" class="outlineBtn">Order Now</a>';
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
					echo '<a href="' . $productPermalink . '" class="outlineBtn">Order Now</a>';
					echo '</div><!--end .info-->';
					echo '</div><!--end .full-->';

				}

				echo '</div><!--end .section-->';

			}
		}

		wp_reset_postdata();

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
						<!-- <li data-slug="guest" data-name="Guest"><a href="javascript:;">Guest</a></li> -->
						<li data-slug="date" data-name="Date"><a href="javascript:;">Date</a></li>
					</ul>
				</div><!--end .filter-->
			</div><!--end .filters-->
		</div>
		<div class="items">
			<div class="arrowLeft"><span>previous</span></div>
			<div class="arrowRight"><span>next</span></div>
			<div class="inner">
<?php
		$today = date('F j, Y', strtotime('-45 days'));

		$args_programs = array(
			'post_type' => 'programs',
			'post_status' => array('publish', 'pending', 'draft', 'future'),
			'date_query' => array(
				array(
					'after' => $today,
					'inclusive' => true,
				),
			),
			'posts_per_page' => 12,
			'orderby' => 'date',
			'order' => 'ASC'
		);

		$query_programs = new WP_Query( $args_programs );

		if ( $query_programs->have_posts() ) {
			echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';

			while ( $query_programs->have_posts() ) {
				$query_programs->the_post();
				$program_title = get_field('program_title');
				$program_series = get_the_terms(get_the_id(),'series');
				$program_image = get_field('program_image');
				$program_desc = get_field('program_description');
				//var_dump($program_series);
				$displayedSeries = $program_series[0];
				$currentSeries = $program_series[0]->name;
				//echo 'HERE11 - ' . $displayedSeries->slug;
				//echo 'HERE11 - ' . $program_image['url'];
				echo '<div class="swiper-slide">';
				echo '<a href="/series/' . $displayedSeries->slug . '"><img src="' . $program_image['url'] . '" /></a>';
				echo '</div>';
			}

			echo '</div>';
			echo '</div>';
		}

		wp_reset_postdata();
?>

			</div><!--end .inner-->
		</div><!--end .items-->
		<?php //get_sidebar('program-archive'); ?>
	</div><!--end .section-->

	<div class="section cols">
		<div class="content">
			<div class="left">
				<?php get_sidebar('haven-now-widget'); ?>
			</div><!--end .left-->
			<div class="right">
				<?php get_sidebar('anchor-widget'); ?>
			</div><!--end .right-->
			<div class="mid"></div>
		</div><!--end .content-->
	</div><!--end .section-->

<?php get_footer(); ?>
