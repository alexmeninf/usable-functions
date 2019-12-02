<?php 
global $woocommerce;
$items = $woocommerce->cart->get_cart();

foreach($items as $item => $values) { 
	$_product =  wc_get_product( $values['data']->get_id() );
	//product image
	$getProductDetail = wc_get_product( $values['product_id'] );
	echo $getProductDetail->get_image(); // accepts 2 arguments ( size, attr )

	echo "<b>".$_product->get_title() .'</b>  <br> Quantity: '.$values['quantity'].'<br>'; 
	$price = get_post_meta($values['product_id'] , '_price', true);
	echo "  Price: ".$price."<br>";
	/*Regular Price and Sale Price*/
	echo "Regular Price: ".get_post_meta($values['product_id'] , '_regular_price', true)."<br>";
	echo "Sale Price: ".get_post_meta($values['product_id'] , '_sale_price', true)."<br>";
}
