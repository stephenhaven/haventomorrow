<?php
/**
Template Name: Anchor Archives
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */

 get_header();
 get_template_part( 'template-parts/content', 'title' ); ?>

 <section class="c-padding-75">
   <div class="container">

	<?php
		$currYear = date('Y');
		$getYear = $_GET['y'];
		if ($getYear == '' || $getYear == undefined || $getYear == null) {
			$useYear = $currYear;
		} else {
			$useYear = $getYear;
		}
		$args_anchor = array(
			'post_type' => 'anchor',
			'posts_per_page' => -1,
			'date_query' => array(
				array(
					'year'  => $useYear
				),
			),
		);

		$query_anchor = new WP_Query( $args_anchor );
		$temp_month = '';
		$temp_year = '';
		$count = 0;

		echo '<div class="section anchor sub">';
			echo '<h1>' . $useYear . '</h1>';
			echo '<hr />';
			echo '<div class="content">';
				echo '<div class="anchorAchrive">';
						if ( $query_anchor->have_posts() ) {
							while ( $query_anchor->have_posts() ) {
								$query_anchor->the_post();

								$date = get_the_date('m.d.y');
								$month = get_the_date('F');
								$year = get_the_date('Y');
								$title = get_the_title();
								$permalink = get_the_permalink();

								if($temp_month == '' || $temp_month != $month){
									$temp_month = $month;
									$print_close = true;
									if($count > 0){
										echo '</ul>';
										echo '</div>';
										echo '</div>';
										echo '<div class="monthContainer">';
										echo '<h2>' . $month . ' ' . $year . '</h2>';
										echo '<div class="month off">';
										echo '<ul>';
									} else {
										echo '<div class="monthContainer">';
										echo '<h2>' . $month . ' ' . $year . '</h2>';
										echo '<div class="month">';
										echo '<ul>';
									}
								}

								if($count % 2 == 0){
									echo '<li class="odd"><a href="'.$permalink.'"><div class="date">' . $date . '</div><div class="title">' . $title . '</div></a></li>';
								} else {
									echo '<li class="even"><a href="'.$permalink.'"><div class="date">' . $date . '</div><div class="title">' . $title . '</div></a></li>';
								}

								$count++;

							}
						}
						echo '</ul>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="items">';
			echo '<h3>Previous Years</h3>';
			echo '<div class="years">';
			$yearLength = (int)$currYear - 2013;
			for ($i=0; $i<=$yearLength; $i++) {
				$yearPag = (int)$currYear - $i;
				echo '<a href="/anchor/?y=' . $yearPag . '">' . $yearPag . '</a>';
				echo '<div class="yearDiv">|</div>';
			}
			echo '</div></div><!--end .items-->' . PHP_EOL;
		echo '</div><!--end .section-->' . PHP_EOL;

		wp_reset_postdata();

		?>
	</div>
</section>

<?php get_footer(); ?>
