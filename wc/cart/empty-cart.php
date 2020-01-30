<?php
// check for empty-cart get param to clear the cart
add_action( 'woocommerce_cart_actions', 'add_button_empty_cart' );
function add_button_empty_cart() { 
	if ( WC()->cart->get_cart_contents_count() > 1 ) { ?>
		<a class="button empty-btn" href="<?= wc_get_cart_url(); ?>?empty-cart"><?php _e( 'Limpar carrinho', 'woocommerce' ); ?></a>
	<?php }
}

add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
  global $woocommerce;
	
	if ( isset( $_GET['empty-cart'] ) ) {
		$woocommerce->cart->empty_cart(); 
	}
}