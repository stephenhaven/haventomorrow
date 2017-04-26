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
              $label = get_sub_field('label');
              $title = get_sub_field('title');
              $description = get_sub_field('description');
              $img = get_sub_field('slider_image');
              $text = get_sub_field('button_text');
              $link = get_sub_field('button_link');
              //print_r($link);
              ?>
          <?php if( $img ): ?>
            <div style="background-image: url('<?php echo $img; ?>');" class="main-slider-slide">
          <?php endif; ?>
              <div class="hero-container">
                <a href="#" class="play-program"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/play.png"></a>
              <?php if( $label ): ?>
                <h5><?php echo $label; ?></h5>
              <?php endif; ?>
              <?php if( $title ): ?>
                <h1><?php echo $title; ?></h1>
              <?php endif; ?>
              <?php if( $description ): ?>
                <p><?php echo $description; ?></p>
              <?php endif; ?>
              <?php if( $link ): ?>
                <a href="<?php echo $link; ?>" class="o-button"><?php if( $text ): ?><?php echo $text; ?><?php endif; ?></a>
              <?php endif; ?>
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
        if( have_rows('featured_product_slider') ):

          // loop through the rows of data
            while ( have_rows('featured_product_slider') ) : the_row();

                // display a sub field value
                $premium = get_sub_field('premium');
                $desc = get_sub_field('brief_description');
                $img = get_sub_field('premium_image');
                $link = get_sub_field('premium_link');
            ?>

            <div>
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
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider.jpg" width="100%">
      </div>
      <div class="col-md-1">
      </div>
      <div class="col-md-7">
        <h3 class="text-center">RECENT PRODUCTS</h3>
        <div class="slider-recent-products">
          <div class="container">
          <div class="row">
        <?php
            if( have_rows('slider_recent_products') ):

              // loop through the rows of data
                while ( have_rows('slider_recent_products') ) : the_row();

                    // display a sub field value
                    $premium = get_sub_field('premium');
                    $img = get_sub_field('image');
                    $link = get_sub_field('link');
                ?>

                  <div class="col-md-4 text-center">
                    <div class="v-middle">
                      <?php if( $img ): ?>
                      <img src="<?php echo $img; ?>">
                      <?php endif; ?>
                      <?php if( $premium ): ?>
                      <h5 class="text-center"><a href="<?php if( $link ): ?><?php echo $link; ?><?php endif; ?>"><?php echo $premium; ?></a></h5>
                      <?php endif; ?>
                    </div>
                  </div>

        <?php endwhile; ?>

      </div>
      </div>
    </div>
      <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function(){
    $('.slider-recent-products').slick({});
  });
</script>

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
