<?php
/**
 * Single Product Minimum Price
 */

// For Haven - No need to display this label

global $product;
		
if ( empty( $product->minimum ) )
	$product->minimum = get_post_meta( $product->id, '_min_donation', true );
	
$html = sprintf( _x( '%s: %s', 'In case you need to change the order of Minimum Price: $minimum', 'wc_name_your_price', 'wc_name_your_price' ), get_option( 'woocommerce_donation_minimum_text', __('Minimum Price', 'wc_name_your_price' ) ), woocommerce_price( $product->minimum ) );

?> 

<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer" style="display:none">
	
	<p itemprop="price" class="minimum-price"><?php echo $html; ?></p>
	
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
	
</div>