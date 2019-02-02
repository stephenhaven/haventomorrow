<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage PJS
 * @since PJS 1.0
 */
?>

<script>

function changeFilter(e){

	var filter = e.attr('data-filter');
	console.log(filter);
	$('.search_filter_order').val(filter);

}

$(document).ready(function() {
	$('.filterOption').click(function(){

		var filter = $(this).data('filter');
		var text = $(this).text();

		$('.currentFilter').html(text);

	});
});
</script>

<div class="section storeSearch">
	<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="searchForm searchFilters">
		<div class="filter">
			<span class="arrow">icon</span>
			<span class="current currentFilter">All Products</span>
			<ul>
				<li><a href="javascript:;" class="filterOption" data-filter="">All Products</a></li>
				<li><a href="javascript:;" class="filterOption" data-filter="popularity">Popularity</a></li>
				<li><a href="javascript:;" class="filterOption" data-filter="date">Newness</a></li>
				<li><a href="javascript:;" class="filterOption" data-filter="price">Low to High</a></li>
				<li><a href="javascript:;" class="filterOption" data-filter="price-desc">High To Low</a></li>
				<!--<li><a href="javascript:;">Category</a></li>
				<li><a href="javascript:;">Series</a></li>
				<li><a href="javascript:;">Guest</a></li>
				<li><a href="javascript:;">Date</a></li>-->
			</ul>
		</div><!--end .filter-->
		<input type="text" class="search-field" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" placeholder="Search our store..." />
		<input type="hidden" name="post_type" value="product" />
		<input type="hidden" class="search_filter_order" name="orderby" value=""/>
		<input type="submit" value="Search" />
	</div><!--end .searchForm-->
	</form>
	<?php
		if (get_field('store_nav_items')) {
			echo '<ul class="nav">';
			while (has_sub_field('store_nav_items')) {
				if (get_sub_field('new_window')) {
					$sniWin = ' target="_blank"';
				} else {
					$sniWin = '';
				}
				echo '<li><a href="' . get_sub_field('link') . '"' . $sniWin . '>' . get_sub_field('name') . '</a></li>';
			}
			echo '</ul>';
		}
	?>
	<div class="mobileStoreNav">
		<?php
			if (get_field('store_nav_items',33514)) {
				echo '<select onchange="if (this.value) window.location.href=this.value">' . PHP_EOL;
				while (has_sub_field('store_nav_items',33514)) {
					if (get_sub_field('new_window',33514)) {
						$sniWin = ' target="_blank"';
					} else {
						$sniWin = '';
					}
					echo '<option value="' . get_sub_field('link',33514) . '">' . get_sub_field('name',33514) . '</option>' . PHP_EOL;
				}
				echo '</select>' . PHP_EOL;
			}
		?>
	</div>
</div><!--end .section-->
