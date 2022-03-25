<?php

/**
 * 
 * Funções para alteração de preços por tipos de usuário.
 * 
 * Este arquivo irá aplicar valores especificos para cada usuário logado na loja
 * 
 */
if (!defined('ABSPATH'))
  exit;

if (is_admin())
  return;

/**
 * role_change_price_simple_product
 * 
 * Altera o preço do produto na loja de um produto simples
 * 
 * Usuário comum: o sale_price não é alterado caso wcj_price_by_user_role_enabled * esteja habilitado somente para wholesalers.
 * Localização no painel (Woocommerce > Settings > Booster > Price based on User Role)
 * 
 * @version 1.0
 *
 * @param  mixed $price
 * @param  mixed $product
 * @return void
 */
add_filter('woocommerce_product_get_price', 'role_change_price_simple_product', 99, 2);
add_filter('woocommerce_product_get_regular_price', 'role_change_price_simple_product', 99, 2);

function role_change_price_simple_product($price, $product)
{
  if (!is_user_logged_in()) return $price;

  if (user_has_role('wholesaler') && $product->is_type('simple')) {

    if ( is_on_sale_wholesaler($product->get_ID()) ) {
      $price = get_post_meta($product->get_ID(), '_wc_wholesaler_sale_price', true);
      
    } elseif (get_post_meta($product->get_ID(), '_wc_wholesaler_regular_price', true) !== '') {
      $price = get_post_meta($product->get_ID(), '_wc_wholesaler_regular_price', true);
    }
  }

  return $price;
}
