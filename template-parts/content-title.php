<?php
/**
 * Template part for displaying page title
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package haventomorrow
 */

?>

<section class="c-padding-180 dark" style="background-image:url('<?php the_field('banner_image'); ?>')">
  <div class="container">
    <h1 class="is-center"><?php wp_title('', true,''); ?></h1>
  </div>
</section>
