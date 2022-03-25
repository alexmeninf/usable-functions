<?php 

if (!defined('ABSPATH'))
  exit;

/**
 * filter_user_needs_payment
 * 
 * Verifica se o usuário precisa de método de pagamento. 
 * Caso esteja desabilitado será removido o método de pagamento e frete.
 *
 * @return void
 */
function filter_user_needs_payment() {
  if (user_has_role('wholesaler')) {
    if ( WHOLESALER_NEEDS_PAYMENT ) {
      return true;      
    } else {  
      return false;
    }
  } else {
    if ( CUSTOME_NEEDS_PAYMENT ) {
      return true;      
    } else {  
      return false;
    }
  }
}

add_filter('woocommerce_cart_needs_payment', 'filter_user_needs_payment', 10, 1);


/**
 * filter_wholesaler_needs_shipping
 * 
 * Desabilita os métodos de entrega se não tiver método de pagamento para o atacadista.
 *
 * @param  mixed $needs_shipping
 * @return void
 */
function filter_wholesaler_needs_shipping( $needs_shipping ) {

  if ( filter_user_needs_payment() ) {
    $needs_shipping = true;      
  } else {  
    $needs_shipping = false;
  }
  
  return $needs_shipping;
}

add_filter( 'woocommerce_cart_needs_shipping', 'filter_wholesaler_needs_shipping' );


/**
 * Desativar a compra para usuário não aprovados como atacadista
 */
if (! user_has_role('wholesaler') ) {
  // Remover botão para o Checkout
  remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);

  // Remover botão de finalização do pedido
  add_filter('woocommerce_order_button_html', function ( $button ) {
    return '';
  });
}