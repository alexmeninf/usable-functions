<?php 
/*
 * Passo a passo da compra
 * @version 1.0
 * @author Alexandre Menin
 * 
 */
 
 function purchase_step_page($custom_class = '') {
   $cart_step           = is_cart() || is_checkout() ? 'class="active"' :  "";
   $checkout_step       = is_checkout() || is_wc_endpoint_url( "order-received" ) ? 'class="active"' :  '';
   $order_received_step = is_wc_endpoint_url( "order-received" ) ? 'class="active"' :  '';


  $layout = '<ul class="purchase-steps list-inline ml-0 ' . $custom_class . '">
    <li ' . $cart_step . '>
      <i class="finished fal fa-check-circle wow zoomIn"></i>
      <div class="wrap">
        <i class="icon fal fa-shopping-bag"></i>
        <span>Carrinho</span>
      </div>
    </li>

    <li ' . $checkout_step .'>
      <i class="finished fal fa-check-circle wow zoomIn" data-wow-delay=".2s"></i>
      <div class="wrap">
        <i class="icon fal fa-truck"></i>
        <span>Entrega e pagamento</span>
      </div>
    </li>

    <li ' . $order_received_step . '>
      <div class="wrap">
        <i class="icon fal fa-check-circle"></i>
        <span>Confirmação</span>
      </div>
    </li>
  </ul>';

  return $layout;
}
add_filter( 'theme_purchase_step_page', 'purchase_step_page', 10, 1);
