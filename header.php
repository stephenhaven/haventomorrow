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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="https://use.typekit.net/emp1lty.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,600i,800,800i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Alegreya" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/style.css">
<<<<<<< Updated upstream

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
=======
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
>>>>>>> Stashed changes
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

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<a href="/"><img src="<?php echo get_bloginfo('template_url') ?>/assets/img/logo-haven@2x.png" alt="Haven Ministries" width="162px"></a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'haventomorrow' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
