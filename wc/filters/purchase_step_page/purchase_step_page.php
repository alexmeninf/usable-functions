<?php
/*
 * Passo a passo da compra
 * @version 1.0
 * @author Alexandre Menin
 * 
 */

function purchase_step_page($custom_class = '') {
  $layout = null;

  // Class names
  $cart_step           = is_cart() ? 'class="current"' : (is_checkout() ? 'class="finished"' :  '');
  $checkout_step       = (is_checkout() && !is_wc_endpoint_url("order-received")) ? 'class="current"' : (is_wc_endpoint_url("order-received") ? 'class="finished"' :  '');
  $order_received_step = is_wc_endpoint_url("order-received") ? 'class="finished"' :  '';

  // Current titles
  $cart_title           = is_cart() ? 'Analise os itens no carrinho.' : (is_checkout() ? 'Revisão de itens completa!' :  '');
  $checkout_title       = (is_checkout() && !is_wc_endpoint_url("order-received")) ? 'Preencha os campos com seus dados.' : ((is_checkout() || is_cart()) && !is_wc_endpoint_url("order-received") ? 'Entrega e pagamento' :  'Pagamento e entrega finalizados!');
  $order_received_title = is_wc_endpoint_url("order-received") ? 'Compra confirmada com sucesso!' :  'Confirmação da compra.';

  if ((is_cart() && WC()->cart->get_cart_contents_count() > 0) || is_checkout()) {
    $layout = '<ul class="purchase-steps list-inline ml-0 ' . $custom_class . '">
      <li ' . $cart_step . ' title="Etapa 1: ' . $cart_title . '">
        <i class="icon-finished fal fa-check-circle wow zoomIn"></i>
        <div class="wrap">
          <i class="icon fal fa-shopping-bag"></i>
          <span>Carrinho</span>
        </div>
      </li>

      <li ' . $checkout_step . ' title="Etapa 2: ' . $checkout_title . '">
        <i class="icon-finished fal fa-check-circle wow zoomIn" data-wow-delay=".2s"></i>
        <div class="wrap">
          <i class="icon fal fa-truck"></i>
          <span>Entrega e pagamento</span>
        </div>
      </li>

      <li ' . $order_received_step . '  title="Etapa 3: ' . $order_received_title . '">
        <i class="icon-finished fal fa-check-circle wow zoomIn"></i>
        <div class="wrap">
          <i class="icon fal fa-check-circle"></i>
          <span>Confirmação</span>
        </div>
      </li>
    </ul>';
  }

  return $layout;
}
add_filter('theme_purchase_step_page', 'purchase_step_page', 10, 1);
