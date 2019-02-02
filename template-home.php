<?php
/**
 * Template Name: Home Template
 */
?>
<?php get_header(); ?>
<?php

/*
 * The code below is used to extract the current post ID so we can launch the player to the first series audio result.
 */

/*

$args_programs = array(
	'post_type' => 'programs',
	'post_status' => array('publish'),
	'posts_per_page' => 5,
	'orderby' => 'date',
	'order' => 'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => 'series',
			'field' => 'slug',
			'terms' => strtolower($seriesName)
		)
	)
);

$query_programs = new WP_Query($args_programs);
$tile_array = array();
$currentPodcastId;
$currentPodcastDate;

if ($query_programs->have_posts()) {
	$currentSeries = "";
	$stillInSeries = true;
	$countposts = 0;
	$thisPostID = 0;
	while ( $query_programs->have_posts() ) {
		$query_programs->the_post();
		if ($countposts == 0) {
			$currentPodcastId = get_the_id();
			$currentPodcastDate = get_the_date();
		}
		$countposts++;
	}
}

$year = date("Y",strtotime($currentPodcastDate));
$month = date("m",strtotime($currentPodcastDate));
$day = date("d",strtotime($currentPodcastDate));
$event = mktime(00, 00, 00, $month, $day, $year);

*/

?>


<section class="dark slider-main">
  <?php
      if( have_rows('sliders') ):

	// loop through the rows of data
	while ( have_rows('sliders') ) : the_row();

	// display a sub field value
	$label = get_sub_field('label');
	$title = get_sub_field('title');
	$description = get_sub_field('description');
	$img = get_sub_field('slider_image');
	$link = get_sub_field('series_link');

	date_default_timezone_set('America/Los_Angeles');
	$year = date("Y",strtotime("now"));
	$month = date("m",strtotime("now"));
	$day = date("d",strtotime("now"));
	$event = get_sub_field('podcastID');
	$id = get_sub_field('postid');
	$playImage = get_stylesheet_directory_uri().'/assets/img/play.png';

	?>
          <?php if( $img ): ?>
            <div style="background-image: url('<?php echo $img; ?>');" class="main-slider-slide">
          <?php endif; ?>
              <div class="container hero-container">
                <a class="play-program mobile-hide play" data-playing="0" data-username="haven" onClick="javascript:PlayProgramAudio(<?php echo $event; ?>, <?php echo $id; ?>)"><img src="<?php echo $playImage; ?>"></a>
              <?php if( $label ): ?>
                <h5><?php echo $label; ?></h5>
              <?php endif; ?>
              <?php if( $title ): ?>
                <h1><?php echo $title; ?></h1>
              <?php endif; ?>
              <?php if( $description ): ?>
                <p><?php echo $description; ?></p>
              <?php endif; ?>
                <a class="o-button" href="<?php echo $link; ?>">View Series</a>
              </div>
            </div>


          <?php endwhile; ?>

      <?php endif; ?>
</section>
<script>
  $(document).ready(function(){
    $('.slider-main').slick({});
  });
</script>

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
  <script>
    $(document).ready(function(){
      $('.slider-premium').slick({});
    });
  </script>

<section class="c-padding-75 light-2">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3>MEET THE SPEAKER</h3>
        <h4>Charles Morris</h4>
        <p>Charles had been asking the Lord to use his journalism background and communication skills for the Kingdom when the phone rang in early 2000 and he was asked to become the fourth speaker on an 80-year-old Christian radio program based in Los Angeles called Haven Today.</p>
        <p><a href="/about" class="o-button">Learn More</a></p>
      </div>
      <div class="col-md-7">
        <a href="/about"><img src="/wp-content/uploads/2017/10/Charles-homepage.jpg"></a>
      </div>
    </div>
  </div>
</section>

<section class="c-padding-75">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3 class="text-center">GOING DEEPER</h3>
        <div class="slider_featured_events">
        <?php
            if( have_rows('slider_featured_events') ):

              // loop through the rows of data
                while ( have_rows('slider_featured_events') ) : the_row();

                    // display a sub field value
                    $img = get_sub_field('image');
                    $link = get_sub_field('link');
                ?>

                <div>
                  <a href="<?php if( $link ): ?><?php echo $link; ?><?php endif; ?>"><img src="<?php if( $img ): ?><?php echo $img; ?><?php endif; ?>"></a>
                </div>

        <?php endwhile; ?>

      </div>

      <?php endif; ?>
      </div>
      <script>
        $(document).ready(function(){
          $('.slider_featured_events').slick({});
        });
      </script>
      <div class="col-md-1">
      </div>
      <div class="col-md-7">
        <h3 class="text-center">FEATURED OFFERS</h3>
        <div class="recent_products">
          <div class="pure-g">
        <?php
            if( have_rows('slider_recent_products') ):
              $i=0;
              // loop through the rows of data
                while ( have_rows('slider_recent_products') ) : the_row();

                    // display a sub field value
                    $premium = get_sub_field('premium');
                    $img = get_sub_field('image');
                    $link = get_sub_field('link');

                    $i++;
              			if( $i > 3 )
              			{
              				break;
              			}
                ?>


                  <div class="pure-u-md-1-3 text-center featured_offers">
                      <?php if( $img ): ?>
                      <a href="<?php if( $link ): ?><?php echo $link; ?><?php endif; ?>"><img src="<?php echo $img; ?>"></a>
                      <?php endif; ?>
                      <?php if( $premium ): ?>
                      <h5 class="text-center"><a href="<?php if( $link ): ?><?php echo $link; ?><?php endif; ?>"><?php echo $premium; ?></a></h5>
                      <?php endif; ?>
                  </div>
        <?php endwhile; ?>
        </div>
      </div>
    </div>
      <?php else: ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="c-padding-25-100 blog light-2">
  <div class="container">
    <div class="row">
        <?php

				$args_anchor = array(
					'post_type' => 'anchor',
					'posts_per_page' => 1,
					'post_status' => 'publish'
				);

				$query_anchor = new WP_Query( $args_anchor );

				if ( $query_anchor->have_posts() ) {
					while ( $query_anchor->have_posts() ) {
						$query_anchor->the_post();

						$anchor_title = get_field('anchor_title');
						$anchor_description = get_field('anchor_description');
						$anchor_image = get_field('anchor_image');
						$anchor_date = get_the_date('l / F jS Y');
						$anchor_permalink = get_the_permalink();

						echo '<div class="col-md-5">';
            echo '<div class="row"><div class="col-md-2">';
            echo '<img class="float-left" src="/wp-content/uploads/2017/10/AnchorToday_color.png" height="50px"></div>';
            echo '<div class="col-md-10">';
						echo '<h3>ANCHOR DEVOTIONAL</h3>';
									echo '<p style="margin-bottom: 2px;"><strong>'.$anchor_title.'</strong></p>';
									echo '<p><em>'.$anchor_date.'</em><p></div></div>';
                  echo '<div class="content">';
    								echo '<div class="right">';
									echo '<p>'.strip_tags(pjs_truncate($anchor_description,400), '<br>').'</p>';
								echo '<a href="'.$anchor_permalink.'" class="o-button">Keep Reading</a>';
								echo '</div><!--end .right-->';
							echo '</div><!--end .content-->';
						echo '</div><!--end .section-->';

					}
				}

				wp_reset_postdata();

				?>
      <div class="col-md-1 border-right">
      </div>
      <div class="col-md-1">
      </div>
      <div class="col-md-5">
        <div class="row"><div class="col-md-2">
          <img class="float-left" src="/wp-content/uploads/2017/10/Blogpost_color.png" height="50px"></div>
          <div class="col-md-10">
        <h3>FEATURED BLOG POST</h3>
        <?php
          $query = new WP_Query(array(
              'posts_per_page'   => 1,
          ));

          while ($query->have_posts()): $query->the_post(); ?>
                  <p style="margin-bottom: 2px;"><strong><?php the_title(); ?></strong></p>
                  <p><em><?php the_date('l / F jS Y'); ?></em><p></div></div>
                  <?php the_excerpt(); ?>
                  <a class="o-button" href="<?php the_permalink(); ?>">Keep Reading</a>
          <?php endwhile;
          ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
