<?php

/**
 * Gerenciar preços de produtos variados para atacadistas
 */
if (!defined('ABSPATH'))
  exit;
  
/**
 * action_wc_variations_options_price
 * Adiciona um novo campo para preço de atacado aos produtos variados.
 * 
 * @param  object $loop 
 * @param  object $variation_data - Conteúdo do produto variado
 * @param  object variation - variação
 * 
 * @return mixed
 */

add_action('woocommerce_variation_options_pricing', 'action_wc_variations_options_price', 10, 3);

function action_wc_variations_options_price($loop, $variation_data, $variation)
{
  // Preço atacadista
  woocommerce_wp_text_input(
    array(
      'id'      => '_wc_wholesaler_variation_price[' . $loop . ']',
      'type'    => 'text',
      'default' => '0',
      'label'   => sprintf(__('Preço Atacadista (%s)', 'woocommerce'), get_woocommerce_currency_symbol()),
      'value' => get_post_meta($variation->ID, '_wc_wholesaler_variation_price', true)
    )
  );

  // Preço promicional atacadista
  woocommerce_wp_text_input(
    array(
      'id'      => '_wc_wholesaler_variation_sale_price[' . $loop . ']',
      'type'    => 'text',
      'default' => '0',
      'label'   => sprintf(__('Preço Atacadista Promocional (%s)', 'woocommerce'), get_woocommerce_currency_symbol()),
      'value' => get_post_meta($variation->ID, '_wc_wholesaler_variation_sale_price', true)
    )
  );
}


/**
 * add_custom__wc_wholesaler_variation_price
 * Adiciona os campo ao objeto meta
 * 
 * @param  string $variation_id - ID do produto variado 
 * @param  string $i - index
 * 
 * @return mixed
 */

add_action('woocommerce_save_product_variation', 'add_custom__wc_wholesaler_variation_price', 10, 2);

function add_custom__wc_wholesaler_variation_price($variation_id, $i)
{
  $custom_wholesaler_price = $_POST['_wc_wholesaler_variation_price'][$i];
  $custom_wholesaler_sale_price = $_POST['_wc_wholesaler_variation_sale_price'][$i];

  if (isset($custom_wholesaler_price))
    update_post_meta($variation_id, '_wc_wholesaler_variation_price', esc_attr(str_replace(',', '.', $custom_wholesaler_price)));
  
  if (isset($custom_wholesaler_sale_price))
    update_post_meta($variation_id, '_wc_wholesaler_variation_sale_price', esc_attr(str_replace(',', '.', $custom_wholesaler_sale_price)));
}


/**
 * save_wholesaler_variation_price_data
 * Armazena o valor do campo personalizado (_wc_wholesaler_variation_price) nos dados da variação
 * 
 * @param  object $variations - Objeto de variações
 * 
 * @return mixed
 */

add_filter('woocommerce_available_variation', 'save_wholesaler_variation_price_data');

function save_wholesaler_variation_price_data($variations)
{
  $variations['_wc_wholesaler_variation_price'] = '<div class="woocommerce_custom_field">Preço Atacadista: <span>' . get_post_meta($variations['variation_id'], '_wc_wholesaler_variation_price', true) . '</span></div>';
  $variations['_wc_wholesaler_variation_sale_price'] = '<div class="woocommerce_custom_field">Preço Atacadista Promocional: <span>' . get_post_meta($variations['variation_id'], '_wc_wholesaler_variation_sale_price', true) . '</span></div>';
  
  return $variations;
}