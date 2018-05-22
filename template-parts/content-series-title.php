<?php
/**
 * Template part for displaying page title
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haventomorrow
 */

?>

<section class="c-padding-180 dark" style="background-image:url('<?php the_field('current_series_banner_image', 'option'); ?>')">
  <div class="container">
    <h1 class="is-center"><?php the_field('current_series_name', 'option'); ?></h1>
  </div>
</section>
