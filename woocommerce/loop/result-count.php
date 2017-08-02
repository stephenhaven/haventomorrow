<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( ! woocommerce_products_will_display() )
	return;

$paged    = max( 1, $wp_query->get( 'paged' ) );
$per_page = $wp_query->get( 'posts_per_page' );
$total    = $wp_query->found_posts;
$first    = ( $per_page * $paged ) - $per_page + 1;
$last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

?>
<span class="txt right">
	<span class="pagination">
		<!--<a href="javascript:;" class="prev"><span>icon</span></a>-->
		<?php printf( _x( 'Pg %1$d Of %2$d', '%1$d = first, %2$d = last', 'woocommerce' ), $first, $last); ?>
		<a href="javascript:;" class="next"><span>icon</span></a>
	</span>
</span>

<span class="txt right">
	<?php	

	if ( 1 == $total ) {
		_e( '1 Result', 'woocommerce' );
	} elseif ( $total <= $per_page || -1 == $per_page ) {
		printf( __( '%d Results', 'woocommerce' ), $total );
	} else {
		printf( _x( '%1$d&ndash;%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
	}
	?>
</span>
