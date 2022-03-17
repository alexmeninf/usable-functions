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
 * role_change_price_variations_product
 *
 * Altera o preço do produto variável
 *
 * @param mixed $price
 * @param mixed $variation
 * @return mixed
 */
add_filter('woocommerce_product_variation_get_regular_price', 'role_change_price_variations_product', 10, 2);
add_filter('woocommerce_product_variation_get_price', 'role_change_price_variations_product', 10, 2);

function role_change_price_variations_product($price, $variation)
{
  if (user_has_role('wholesaler') && $variation->is_type('variation')) {
    if (get_post_meta($variation->variation_id, '_wc_wholesaler_variation_price', true) !== '') {
      $price = get_post_meta($variation->variation_id, '_wc_wholesaler_variation_price', true);
    }
  }

  return $price;
}

/**
 * 
 * Atualiza o preço do produto simples na loja
 * 
 * @version 1.0
 */
add_filter('woocommerce_get_price_html', 'change_product_price_display', 10, 2);

function change_product_price_display($price, $product)
{
  // Remove o preço em promoção do usuário normal.
  if (user_has_role('wholesaler') && $product->is_type('simple') && $product->get_price() > 0) {
    if ($product->is_on_sale() && get_option('wcj_price_by_user_role_enabled') == 'no') {
      $price = wc_price($product->get_price());
    }
  }

  // Ajusta o preço para produtos variaveis
  if (user_has_role('wholesaler') && $product->is_type('variation')) {
    if ($product->get_price() > 0) {
      $wholsaler_price = (float) get_post_meta($product->get_ID(), '_wc_wholesaler_variation_price', true);
      $from = $wholsaler_price;
      $to = (float) $product->get_price();

      if ($product->is_on_sale() && get_option('wcj_price_by_user_role_enabled') == 'yes') {
        $price = '<del>' . ((is_numeric($from)) ? wc_price($from) : $from) . '</del> <ins>' . ((is_numeric($to)) ? wc_price($to) : $to) . '</ins>';
      } else {
        $price = (is_numeric($wholsaler_price)) ? wc_price($wholsaler_price) : $wholsaler_price;
      }
    } else {
      $price = '<span>Grátis</span>';
    }
  }

  // Check stock
  if ($product->managing_stock() && !$product->is_in_stock() && !is_product()) {
    $price .= '<span class="d-block msg-stock">Fora de Estoque</span>';
  }

  return $price;
}


/**
 * custom_variable_price
 *
 * Variable (price range)
 *
 * @version 1.0
 *
 * @param mixed $price
 * @param mixed $variation
 * @param mixed $product
 * @return void
 */
add_filter('woocommerce_variation_prices_price', 'custom_variable_price', 99, 3);
add_filter('woocommerce_variation_prices_regular_price', 'custom_variable_price', 99, 3);

function custom_variable_price($price, $variation, $product)
{
  // Deleta o cache do produto (caso precise)
  // Obs: não apague essas linhas
  wc_delete_product_transients($variation->get_id());

  if (user_has_role('wholesaler') && $variation->is_type('variation')) {
    if (get_post_meta($variation->variation_id, '_wc_wholesaler_variation_price', true) !== '') {
      $price = get_post_meta($variation->variation_id, '_wc_wholesaler_variation_price', true);
    }
  }

  return $price;
}


/**
 * filter_show_variation_price
 * 
 * Sempre exibe o preço de variação selecionado para produtos variáveis
 *
 * @param  mixed $condition
 * @param  mixed $product
 * @param  mixed $variation
 * @return boolean
 */
add_filter('woocommerce_show_variation_price', 'filter_show_variation_price', 10, 3);

function filter_show_variation_price($condition, $product, $variation)
{
  if ($variation->get_price() === "") {
    return false;
  } else {
    return true;
  }
}


/**
 * remove_the_displayed_price_from_variable_products
 * 
 * Remova o preço exibido dos produtos variáveis apenas nas páginas de um único produto
 *
 * @return void
 */
add_action('woocommerce_single_product_summary', 'remove_the_displayed_price_from_variable_products', 9);
add_action('woocommerce_after_shop_loop_item_title', 'remove_the_displayed_price_from_variable_products', 9);

function remove_the_displayed_price_from_variable_products()
{
  global $product;

  if (disable_product_price()) {
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
  } else {
    if (user_has_role('wholesaler')) {
      if ($product->is_type('variable')) {
        // Remove the displayed price from variable products
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
  
        echo get_wholesaler_variation_prices($product);
      } else if ($product->is_type('simple')) {
        add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
      }
    } else {
      if ($product->is_type('variable')) {
        // Remove the displayed price from variable products
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
  
        echo get_custom_variation_prices($product);
      }
    }
  }
}


/**
 * 
 * Exibe o menor e maior preço dos produtos variaveis
 * 
 * @version 1.0
 */
function get_wholesaler_variation_prices($product)
{
  $variations = $product->get_available_variations();
  $variations_id = wp_list_pluck($variations, 'variation_id');
  $last_price_max = 0;

  // Pega o maior valor das variações
  foreach ($variations_id as $key => $variation_id) {
    if (wc_get_product($variation_id)->is_on_sale() && get_option('wcj_price_by_user_role_enabled') == 'yes') {
      $price = (float) wc_get_product($variation_id)->get_price();
    } else {
      $price = (float) get_post_meta($variation_id, '_wc_wholesaler_variation_price', true);
    }

    if ($price >= $last_price_max) {
      $last_price_max = $price;
    }
  }

  $last_price_min = $last_price_max;

  // Pega o menor valor das variações
  foreach ($variations_id as $key => $variation_id) {
    if (wc_get_product($variation_id)->is_on_sale() && get_option('wcj_price_by_user_role_enabled') == 'yes') {
      $price = (float) wc_get_product($variation_id)->get_price();
    } else {
      $price = (float) get_post_meta($variation_id, '_wc_wholesaler_variation_price', true);
    }

    if ($price <= $last_price_min) {
      $last_price_min = $price;
    }
  }

  if ($last_price_min !== $last_price_max) {
    return '<p class="price mb-0">' . wc_price($last_price_min) . '</p>';
  } else {
    return '<p class="price mb-0">' . wc_price($last_price_min) . '</p>';
  }
}


/**
 * 
 * Exibe o menor e maior preço dos produtos variaveis
 * 
 * @version 1.0
 */
function get_custom_variation_prices($product)
{
  $variations = $product->get_available_variations();
  $variations_id = wp_list_pluck($variations, 'variation_id');
  $last_price_max = 0;

  // Pega o maior valor das variações
  foreach ($variations_id as $key => $variation_id) {

    $price = (float) wc_get_product($variation_id)->get_price();

    if ($price >= $last_price_max) {
      $last_price_max = $price;
    }
  }

  $last_price_min = $last_price_max;

  // Pega o menor valor das variações
  foreach ($variations_id as $key => $variation_id) {

    $price = (float) wc_get_product($variation_id)->get_price();

    if ($price <= $last_price_min) {
      $last_price_min = $price;
    }
  }

  if ($last_price_min !== $last_price_max) {
    return '<p class="price mb-0">' . wc_price($last_price_min) . '</p>';
  } else {
    return '<p class="price mb-0">' . wc_price($last_price_min) . '</p>';
  }
}
