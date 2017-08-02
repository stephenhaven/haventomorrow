<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

if ( ! $post->post_excerpt ) {
	return;
}

?>
<div itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
</div>

<?php 
$related_series = get_field('related_series');
if($related_series){
	
	echo '<a class="woocommerce-smallbtn" href="/series/' . $related_series->slug . '">Related Series - ' . $related_series->name . '</a>';
}
?>