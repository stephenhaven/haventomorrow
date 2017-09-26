<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package haventomorrow
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/oldStyles.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
  document.getElementsByTagName("html")[0].style.visibility = "visible";
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script><script src="https://use.typekit.net/emp1lty.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,600i,800,800i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Alegreya" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/style.css">
<!--[if lt IE 9]>
<script src="js/html5.js" type="text/javascript"></script>
<![endif]-->

<!--HEADROOM-->
<script src="//cdnjs.cloudflare.com/ajax/libs/headroom/0.7.0/headroom.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/headroom/0.7.0/jQuery.headroom.min.js"></script>

<!--MAIN-->
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js?v=02" type="text/javascript"></script>

<!--SWIPER-->
<script src="//cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.6/js/swiper.jquery.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.6/css/swiper.min.css">

<!--ANIMATION-->
<script src="<?php echo get_template_directory_uri(); ?>/js/scrollReveal.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		window.sr = new scrollReveal();
	});
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'haventomorrow' ); ?></a>

	<div class="top-bar">
		<ul>
			<li><a href="https://www.facebook.com/pages/All-About-Jesus-by-haventodayorg/165484636828241" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
			<li><a href="https://twitter.com/HavenToday/" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
			<li><a href="https://instagram.com/haventoday/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
			<li><a href="https://www.youtube.com/user/HavenToday" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
		</ul>
		<div class="links">
		<a class="signup">Sign Up</a>
		<span>|</span>
		<a class="station">Find a Station</a>
		<span>|</span>
		<a href="tel:+1-800-654-2836" style="cursor:default;"><b>800 654 2836</b></a>
		<span>|</span>
		<a class="search">Search</a>
		<?php
			global $woocommerce;
			if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) {
				echo '<span>|</span>';
				echo '<a class="cart" href="/cart"><span><i class="fa fa-shopping-cart"></i></span>View Cart</a>';
			}
		?>
	</div>
	</div>

	<div class="drop search">
  	<div class="closeBtn">Close<span>x</span></div>
  	<h2>Search</h2>
  	<h3>Type what you are looking for</h3>
  	<hr />
  	<div class="searchForm">
  		<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  			<input type="text" name="s" value="" placeholder="search haven" />
  			<input type="submit" value="Search" />
  		</form>
  	</div><!--end .searchForm-->
  </div><!--end .drop-->

	<div class="drop signup">
		<div class="closeBtn">Close<span>x</span></div>
		<h2>Haven Today Email Updates</h2>
		<h3>Keep up to date with the latest</h3>
		<hr />
		<div class="signupForm">
			<?php echo do_shortcode('[contact-form-7 id="33501" title="Haven Today Email Updates"]'); ?>
			<script>
				$(document).ready(function(){
					$('.options  .checkboxes .cb').click(function() {
						var ninjaid = $(this).data('ninjaid');
						$('.htCheck').each(function(){
							if($(this).is('#' + ninjaid +':checked')){
								$(this).prop("checked", false);
							} else if($(this).is('#' + ninjaid)) {
								$(this).prop("checked", true);
							}
						});
						if ($(this).hasClass('on')) {
							$(this).removeClass('on');
						} else {
							$(this).addClass('on');
						}
					});
				});
			</script>
		</div><!--end .signupForm-->
	</div><!--end .drop-->

	<header id="masthead" class="site-header" role="banner">

    <nav class="navbar navbar-expand-lg navbar-dark bg-light-opened">
        <div class="site-branding">
          <a href="/"><img src="<?php echo get_bloginfo('template_url') ?>/assets/img/logo-haven@2x.png" alt="Haven Ministries" width="162px"></a>
        </div><!-- .site-branding -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <div class="menu-menu-1-container"><ul id="primary-menu" class="menu nav-menu" aria-expanded="false"><li id="menu-item-33383" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home page_item page-item-33398 current_page_item menu-item-33383"><a href="http://haventomorrow.com/">Home</a></li>

            <li id="menu-item-33384" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-33384 nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Listen
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="/program">Today's Program</a>
                <a href="http://haventomorrow.com/program-archive/">Program Archive</a>
                <a href="http://haventomorrow.com/haven-now/">Haven Now</a>
                <a href="http://haventomorrow.com/anchor-today/">Anchor Today</a>
              </div>
            </li>

    				<li id="menu-item-33387" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-33387 nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Resources
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a href="http://haventomorrow.com/blog/">Blog</a>
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

      							$anchor_permalink = get_the_permalink();

      									echo '<a href="'.$anchor_permalink.'">Anchor</a>';

      						}
      					}

      					wp_reset_postdata();

      					?>
                <a href="http://haventomorrow.com/prayer/">Prayer</a>
                <a href="http://haventomorrow.com/knowing-god/">Knowing God</a>
              </div>
    				</li>
    				<li id="menu-item-33553" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-33553"><a href="http://haventomorrow.com/store/">Store</a></li>
    				<li id="menu-item-33391" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-33391 nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                About</a>
    				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a href="/about">About Us</a>
    					<a href="http://haventomorrow.com/financial-accountability/">Financial Accountability</a>
    				</div>
    				</li>
    				<li id="menu-item-33589" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-33589"><a href="/product/give">Give</a></li>
    				</ul></div>
        </div>
      </nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
