<?php
/**
 * 
 * Show save price in product single
*/
function product_you_save() {
	global $product;
	
	if( $product->is_type('simple') || $product->is_type('external') || $product->is_type('grouped') ) {
		$regular_price = get_post_meta( $product->get_id(), '_regular_price', true );
		$sale_price = get_post_meta( $product->get_id(), '_sale_price', true );
		
		if( $product->is_on_sale() ) {
			$amount_saved = $regular_price - $sale_price;
			$currency_symbol = get_woocommerce_currency_symbol();
			
			$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
			?>
			<p class="onsale-info"><b><?php echo number_format($percentage,0, '', '').'%'; ?></b> de desconto</p>
			<?php
		}
	}
} 
add_action( 'woocommerce_single_product_summary', 'product_you_save', 11 );
