<?php
/**
 * Template Name: Program Archive
 */

get_header();

while ( have_posts() ) : the_post();

  // get_sidebar('banner');

  get_template_part( 'template-parts/content', 'title' );  ?>



  <div class="section archive">
    <?php get_sidebar('program-archive'); ?>
  </div>

<?php endwhile;

get_footer(); ?>
