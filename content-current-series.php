<?php
/**
 * Template Name: Current Program Series
 */

get_header();
get_template_part( 'template-parts/content', 'series-title' ); ?>

<section class="c-padding-75">
  <div class="container">
      <script id="subsplash-embed-fhxxb64" type="text/javascript">var target = document.getElementById("subsplash-embed-fhxxb64");var script = document.createElement("script");script.type = "text/javascript";script.onload = function() {subsplashEmbed("+07a8/lb/li/+fhxxb64?embed&branding", "https://subsplash.com/", "subsplash-embed-fhxxb64");};script.src = "https://dashboard.static.subsplash.com/production/web-client/external/embed-1.1.0.js";target.parentElement.insertBefore(script, target);</script>
      <hr/>
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
      <div class="center">
        <p>Looking for an older program? <a href="/program-archive" target="_blank">Click here</a></p>
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
            echo '<div class="row"><div class="col-md-3">';
            echo '<img class="float-left" src="/wp-content/uploads/2017/10/AnchorToday_color.png" height="100px"></div>';
            echo '<div class="col-md-9">';
						echo '<h3>TODAY\'S ANCHOR</h3>';
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
        <div class="row"><div class="col-md-3">
          <img class="float-left" src="/wp-content/uploads/2017/10/Blogpost_color.png" height="100px"></div>
          <div class="col-md-9">
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
