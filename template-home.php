<?php
/**
 * Template Name: Home Template
 */
?>
<?php get_header(); ?>

<section class="dark slider-main">
  <?php
      if( have_rows('sliders') ):

        // loop through the rows of data
          while ( have_rows('sliders') ) : the_row();

              // display a sub field value
              $img = get_sub_field('slider_image');
              $link = get_sub_field('button_link');
              //print_r($link);
              echo "<div style='background-image: url({$img['url']});' class='main-slider-slide'>";
                echo "<div class='main-slider-text-overlay'>" . get_sub_field('text_overlay');
                  echo "<a href='$link' class='main-slider-button'>" . get_sub_field('button_text') . "</a>";
                echo "</div>";
              echo "</div>";

          endwhile;

      else :

          // no rows found

      endif;
  ?>
</section>
<script>
  $(document).ready(function(){
    $('.slider-main').slick({});
  });
</script>

<!-- <section class="c-padding-180 dark" style="background-image:url('http://www.haventoday.org/wp-content/uploads/2015/10/marcus-dall-col-63805.jpg')">
  <div class="container">
    <a href="#" class="play-program"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/play.png"></a>
    <h5>TODAY'S PROGRAM</h5>
    <h1>THE REVELATION OF JESUS CHRIST</h1>
    <p>This one book in the Bible seems intimidating and thrilling. But yet it is probably the most unstudied book by Christians.</p>
    <a href="#" class="o-button">VIEW SERIES</a>
  </div>
</section>
 -->
<section class="c-padding-50 slider-main">
  <div class="container">
    <?php
        if( have_rows('featured_product_slider') ):

          // loop through the rows of data
            while ( have_rows('featured_product_slider') ) : the_row();

                // display a sub field value
                $premium = get_sub_field('premium');
                $desc = get_sub_field('brief_description');
                $img = get_sub_field('premium_image');
                $link = get_sub_field('premium_link');
            ?>

            <div class="row">
              <div class="col-md-4">
                <div class="v-middle">
                  <h3>TODAY'S OFFER</h3>
                  <?php if( $premium ): ?>
                  <h4><?php echo $premium; ?></h4>
                  <?php endif; ?>
                  <?php if( $desc ): ?>
                  <p><?php echo $desc; ?></p>
                  <?php endif; ?>
              </div>
              </div>
              <div class="col-md-4 text-center">
                <?php if( $img ): ?>
                <img src="<?php echo $img; ?>" width="80%">
                <?php endif; ?>
              </div>
              <div class="col-md-4 text-center">
                <div class="v-middle">
                  <?php if( $link ): ?>
                <a href="<?php echo $link; ?>" class="o-button">GET THIS RESOURCE</a>
                <?php endif; ?>
              </div>
              </div>
            </div>

    <?php endwhile; ?>

  </div>

  <?php endif; ?>

  <script>
    $(document).ready(function(){
      $('.slider-main').slick({});
    });
  </script>

</section>

<section class="c-padding-75 light-2">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3>MEET THE SPEAKER</h3>
        <h4>CHARLES MORRIS</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p><a href="#">Learn More >></a></p>
      </div>
      <div class="col-md-7">
        <img src="http://www.haventoday.ca/wp-content/uploads/2015/10/img-about.jpg">
      </div>
    </div>
  </div>
</section>

<section class="c-padding-75">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3 class="text-center">FEATURED</h3>
<!--         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider.jpg" width="100%"> -->
        <?php
          echo do_shortcode('[smartslider3 slider=5]');
        ?>
      </div>
      <div class="col-md-1">
      </div>
      <div class="col-md-7">
        <h3 class="text-center">RECENT PRODUCTS</h3>
<!--         <div class="row">
          <div class="col-md-4 text-center">
            <img src="http://www.haventoday.org/wp-content/uploads/2017/01/JSB10-product-242x308.jpg" width="75%">
            <h5 class="text-center">The Jesus Storybook Bible (Gift Edition)</h5>
          </div>
          <div class="col-md-4 text-center">
            <img src="http://www.haventoday.org/wp-content/uploads/2016/10/GodsNotDead2_DVD-1-242x308.jpg" width="75%">
            <h5 class="text-center">God's Not Dead 2</h5>
          </div>
          <div class="col-md-4 text-center">
            <img src="http://www.haventoday.org/wp-content/uploads/2016/12/FleeingISISFindingJesus-242x308.jpg" width="75%">
            <h5 class="text-center">Fleeing ISIS, Finding Jesus</h5>
          </div>
        </div> -->
        <?php
          echo do_shortcode('[smartslider3 slider=4]');
        ?>
      </div>
    </div>
  </div>
</section>

<section class="c-padding-25-100 blog">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3>TODAY'S ANCHOR</h3>
        <p><img class="float-left" src="http://www.haventoday.ca/wp-content/uploads/2017/01/Anchor01312017-2.jpg" width="100px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p><a href="#">Learn More >></a></p>
      </div>
      <div class="col-md-1 border-right">
      </div>
      <div class="col-md-1">
      </div>
      <div class="col-md-5">
        <h3>FEATURED BLOG POST</h3>
        <p><img class="float-left" src="http://www.haventoday.ca/wp-content/uploads/2017/01/Anchor01312017-2.jpg" width="100px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p><a href="#">Learn More >></a></p>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
