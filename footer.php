<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package haventomorrow
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer dark-2" role="contentinfo">
		<div class="container">
			<ul>
				<li><a href="/">HOME</a></li>
				<li><a href="/give">GIVE</a></li>
				<li><a href="/program-archive">PROGRAM ARCHIVE</a></li>
				<li><a href="/prayer">PRAYER</a></li>
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

								echo '<li><a href="'.$anchor_permalink.'">Anchor</a></li>';

					}
				}

				wp_reset_postdata();

				?>
				<li><a href="/blog">BLOG</a></li>
				<li><a href="/about">ABOUT</a></li>
				<li><a href="/contact">CONTACT</a></li>
				<li><a href="/financial-accountability">FINANCIAL ACCOUNTABILITY</a></li>
				<li><a href="/privacy-policy">PRIVACY POLICY</a></li>
			</ul>
		</div>
	</footer><!-- #colophon -->
	<div class="bottom_bar">
		<p>COPYRIGHT © <?php echo date('Y'); ?> HAVEN MINISTRIES</p>
	</div>
</div><!-- #page -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56045996b0c981a6" async="async"></script>

<?php wp_footer(); ?>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/scripts.js"></script>
</body>
</html>
