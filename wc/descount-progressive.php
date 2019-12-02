<?php
// EXEMPLE BASE

//  Change Product Price Based on Quantity Added to Cart
add_action( 'woocommerce_before_calculate_totals', 'cart_quantity_based_pricing', 9999 );
function cart_quantity_based_pricing( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

	if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;

	// Define discount rules and thresholds
	$threshold1 = 10; // Change price if items > 10
	$discount1 = 5; // Reduce unit price by 5%
	
	$threshold2 = 100;
	$discount2 = 10;
	
	$threshold3 = 300;
	$discount3 = 15;
	
	$threshold4 = 500;
	$discount4 = 20;
	
	$threshold5 = 1000;
	$discount5 = 30; 
	
	foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
		
		$price =    $cart_item['data']->get_price();
		$quantity = $cart_item['quantity'];

		switch ($quantity) {
			case $quantity >= $threshold1 && $quantity < $threshold2:
				$new_price = ($discount1 * $price) / 100;
				$cart_item['data']->set_price( $price - $new_price );
				set_percent_discount_qnt($discount1);
			break;
			
			case $quantity >= $threshold2 && $quantity < $threshold3:
				$new_price = ($discount2 * $price) / 100;
				$cart_item['data']->set_price( $price - $new_price );
				set_percent_discount_qnt($discount2);
			break;

			case $quantity >= $threshold3 && $quantity < $threshold4:
				$new_price = ($discount3 * $price) / 100;
				$cart_item['data']->set_price( $price - $new_price );
				set_percent_discount_qnt($discount3);
			break;

			case $quantity >= $threshold4 && $quantity < $threshold5:
				$new_price = ($discount4 * $price) / 100;
				$cart_item['data']->set_price( $price - $new_price );
				set_percent_discount_qnt($discount4);
			break;

			case $quantity >= $threshold5:
				$new_price = ($discount5 * $price) / 100;
				$cart_item['data']->set_price( $price - $new_price );
				set_percent_discount_qnt($discount5);
			break;
			default: 
				return;
		}
	}
}


// porcentagem
function get_percent_discount_qnt() {
	global $percent_discount_qnt;
	return $percent_discount_qnt; 
}

function set_percent_discount_qnt($value) {
	global $percent_discount_qnt;
	$percent_discount_qnt = $value;
}