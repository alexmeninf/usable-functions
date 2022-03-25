<?php

/**
 * Gerencia dos preços de produtos simples e variados para atacadistas
 */
if (!defined('ABSPATH'))
  exit;

/**
 * action_wc_simple_product_options_price
 * Adiciona um novo campo para preço de atacado aos produtos simples.
 * 
 * @return mixed
 */

add_action('woocommerce_product_options_pricing', 'action_wc_simple_product_options_price', 10, 0);

function action_wc_simple_product_options_price()
{
  woocommerce_wp_text_input(
    array(
      'id'      => '_wc_wholesaler_regular_price',
      'type'    => 'text',
      'default' => '0',
      'label'   => sprintf(__('Preço Atacadista (%s)', 'woocommerce'), get_woocommerce_currency_symbol()),
    )
  );

  woocommerce_wp_text_input(
    array(
      'id'      => '_wc_wholesaler_sale_price',
      'type'    => 'text',
      'default' => '0',
      'label'   => sprintf(__('Preço Atacadista Promocional (%s)', 'woocommerce'), get_woocommerce_currency_symbol()),
    )
  );
};


/**
 * add_custom__wc_wholesaler_regular_price
 * Adiciona o campo de _wc_wholesaler_regular_price ao objeto meta
 *
 * @param  string $post_id - ID do produto.
 * 
 * @return mixed
 */

add_action('woocommerce_process_product_meta', 'add_custom__wc_wholesaler_regular_price');

function add_custom__wc_wholesaler_regular_price($post_id)
{
  if (!empty($_POST['_wc_wholesaler_regular_price']))
    update_post_meta($post_id, '_wc_wholesaler_regular_price', esc_attr(str_replace(',', '.', $_POST['_wc_wholesaler_regular_price'])));
  
  if (!empty($_POST['_wc_wholesaler_sale_price']))
    update_post_meta($post_id, '_wc_wholesaler_sale_price', esc_attr(str_replace(',', '.', $_POST['_wc_wholesaler_sale_price'])));
}


/**
 * save_wholesaler_regular_price
 * Resgata um campo personalizado (_wc_wholesaler_regular_price) e adiciona à resposta da API
 *
 * @param  object $response - Resposta da API.
 * @param  object $post - Objeto do produto.
 * 
 * @return mixed
 */

add_filter('woocommerce_rest_prepare_product', 'save_wholesaler_regular_price', 90, 2);

function save_wholesaler_regular_price($response, $post)
{
  $response->data['_wc_wholesaler_regular_price'] = get_post_meta($post->ID, '_wc_wholesaler_regular_price', true);
  $response->data['_wc_wholesaler_sale_price'] = get_post_meta($post->ID, '_wc_wholesaler_sale_price', true);

  return $response;
}
