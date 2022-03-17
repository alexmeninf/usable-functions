<?php

if (!defined('ABSPATH'))
  exit;

/**
 * disable_product_price
 * 
 * Desabilita a exibição dos valores na loja.
 * Exibe o preço somenta para atacadista, administrador e gerente da loja.
 *
 * @return void
 */
function disable_product_price() {

  if (! is_admin() 
  && ! is_user_logged_in() 
  && DISABLE_PRODUCT_PRICE_TO_CUSTOMER === true 
  && ! user_has_role('wholesaler') ) {
    return true;
  } else {
    return false;
  }
}


/**
 * filter_change_html_price_by_payment
 * Altera o valor exibido no carrinho de cada item, caso não houver método de pagamento habilitado.
 *
 * @param  mixed $price
 * @return string
 */
function filter_change_html_price_by_payment( $price ) {

  if ( disable_product_price() ) {
    $price = __('Preço somente para atacadista', 'menin');
  }

  return $price;
}

add_filter( 'woocommerce_get_price_html', 'filter_change_html_price_by_payment' );
add_filter( 'woocommerce_cart_item_price', 'filter_change_html_price_by_payment' );


/** 
 * woocommerce_cart_item_subtotal
 * Renomeia e zera o valor subtotal dos produtos do carrinho.
 * 
 * @param  mixed $price
 */
add_filter( 'woocommerce_cart_item_subtotal', function ( $price ) {

  if ( disable_product_price() ) {
    $price = get_woocommerce_currency_symbol() . ' 00,00';
  }

  return $price;
});


/**
 * woocommerce_cart_subtotal
 * Renomeia e zera o valor subtotal da compra.
 * 
 * @param  mixed $subtotal
 */
add_filter( 'woocommerce_cart_subtotal', function ( $subtotal ) {

  if ( disable_product_price() ) {
    $subtotal = __('Subtotal somente para atacadista', 'menin');
  }

  return $subtotal;
});


/**
 * woocommerce_cart_total
 * Renomeia o subtotal da compra na pág. do carrinho e checkout.
 *
 * @param  mixed $total
 * @return void
 */
add_filter( 'woocommerce_cart_total', function( $total ) {

  if ( disable_product_price() ) {
    $total = __('O valor só pode ser exibido após aprovação como atacadista cadastrado na loja.', 'menin');
  }

  return $total;
});
