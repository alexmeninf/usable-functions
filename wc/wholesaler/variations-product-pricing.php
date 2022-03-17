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
  woocommerce_wp_text_input(
    array(
      'id'      => '_wc_wholesaler_variation_price[' . $loop . ']',
      'type'    => 'text',
      'default' => '0',
      'label'   => __('Preço Atacadista (R$)', 'woocommerce'),
      'value' => get_post_meta($variation->ID, '_wc_wholesaler_variation_price', true)
    )
  );
}


/**
 * add_custom__wc_wholesaler_variation_price
 * Adiciona o campo de _wc_wholesaler_variation_price ao objeto meta
 * 
 * @param  string $variation_id - ID do produto variado 
 * @param  string $i - index
 * 
 * @return mixed
 */

add_action('woocommerce_save_product_variation', 'add_custom__wc_wholesaler_variation_price', 10, 2);

function add_custom__wc_wholesaler_variation_price($variation_id, $i)
{
  $custom_field = $_POST['_wc_wholesaler_variation_price'][$i];

  if (isset($custom_field))
    update_post_meta($variation_id, '_wc_wholesaler_variation_price', esc_attr($custom_field));
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
  return $variations;
}

/**
 * update_wholesaler_variation_price
 * Adiciona o campo de _wc_wholesaler_variation_price ao objeto meta
 * 
 * @param  string $postID - ID do produto variado 
 * @param  string $post - index
 * 
 * @return mixed
 */

add_action('save_post', 'update_wholesaler_variation_price', 10, 2);
