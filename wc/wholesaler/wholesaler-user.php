<?php

if (!defined('ABSPATH'))
  exit;


/**
 * 
 * Definições para os tipos de usuário.
 * Exibido em functions.php
 * 
 */

// Marque como true esta opção se o cliente ATACADISTA precisa de metodo de pagamento
define('WHOLESALER_NEEDS_PAYMENT', false);

// Marque como true esta opção se o cliente COMUM precisa de método de pagamento
define('CUSTOME_NEEDS_PAYMENT', false);

// Desativa a exibição de preços na loja para usuários que não são atacadista e bloquear compra
define('DISABLE_PRODUCT_PRICE_TO_CUSTOMER', false);


/** 
 * user_has_role 
 * Função para verificar se um usuário tem uma função específica
 * 
 * @param  string  $role    role to check against 
 * @param  int  $user_id    user id
 * @return boolean
 */
function user_has_role($role = '', $user_id = null)
{
  if (is_numeric($user_id))
    $user = get_user_by('id', $user_id);
  else
    $user = wp_get_current_user();

  if (empty($user))
    return false;

  return in_array($role, (array) $user->roles);
}

/**
 * 
 * Atualiza os campos de entrega e faturamento do usuário após registro customizado
 * 
 * */
function wc_update_fields_after_registration_user( $user_id ) {
  
  // Atualizar nome
  if (isset($_POST['first_name']) && !empty($_POST['first_name']) ) :
    update_user_meta( $user_id, 'billing_first_name', $_POST['first_name'] );
    update_user_meta( $user_id, 'shipping_first_name', $_POST['first_name'] );
  endif;

  // Sobrenome
  if (isset($_POST['last_name']) && !empty($_POST['last_name']) ) :
    update_user_meta( $user_id, 'billing_last_name', $_POST['last_name'] );
    update_user_meta( $user_id, 'shipping_last_name', $_POST['last_name'] );
  endif;

  // CPF
  if (isset($_POST['pf_cpf']) && !empty($_POST['pf_cpf']) )
    update_user_meta( $user_id, 'billing_cpf', $_POST['pf_cpf'] );
  
  // CNPJ
  if (isset($_POST['pj_cnpj']) && !empty($_POST['pj_cnpj']) )
    update_user_meta( $user_id, 'billing_cnpj', $_POST['pj_cnpj'] );
  
  // Empresa
  if (isset($_POST['pj_razao_social']) && !empty($_POST['pj_razao_social']) ) :
	  update_user_meta( $user_id, 'billing_company', $_POST['pj_razao_social'] );
	  update_user_meta( $user_id, 'shipping_company', $_POST['pj_razao_social'] );
  endif;

  // Endereço
  if (isset($_POST['billing_address_1']) && !empty($_POST['billing_address_1']) )
	  update_user_meta( $user_id, 'shipping_address_1', $_POST['billing_address_1'] );
  
  // Número
  if (isset($_POST['billing_number']) && !empty($_POST['billing_number']) )
	  update_user_meta( $user_id, 'shipping_number', $_POST['billing_number'] );

  // Bairro
  if (isset($_POST['billing_neighborhood']) && !empty($_POST['billing_neighborhood']) )
	  update_user_meta( $user_id, 'shipping_neighborhood', $_POST['billing_neighborhood'] );

  // Cidade
  if (isset($_POST['billing_city']) && !empty($_POST['billing_city']) )
	  update_user_meta( $user_id, 'shipping_city', $_POST['billing_city'] );
  
  // CEP
  if (isset($_POST['billing_postcode']) && !empty($_POST['billing_postcode']) )
	  update_user_meta( $user_id, 'shipping_postcode', $_POST['billing_postcode'] );
  
  // Estado
  if (isset($_POST['billing_state']) && !empty($_POST['billing_state']) )
	  update_user_meta( $user_id, 'shipping_state', $_POST['billing_state'] );
}
add_action('user_register', 'wc_update_fields_after_registration_user');

/**
 * 
 * Verifica o campo "tipo de pessoa" e manter o valor
 * 
 */
function check_field_persontype() {
  // Valor 1: Pessoa física,
  // Valor 2: Pessoa juridica
  $value_default = '1';

  $billing_persontype = get_user_meta(get_current_user_id(), 'billing_persontype', true);

  $user_meta = get_userdata(get_current_user_id());
  $user_roles = $user_meta->roles; // array of roles the user is part of.

  if ( empty($billing_persontype) ) {
    if ( in_array('wholesaler', (array) $user_roles->roles) || get_preserved_field('tipo_cadastro') == 'pessoa_juridica' ) {
      $value_default = '2';
    } else {
      $value_default = '1';
    }
	  
	  update_user_meta( get_current_user_id(), 'billing_persontype', $value_default );
	  
  } else {
    $value_default = $billing_persontype;
  }

  return $value_default;
}

/**
 * 
 * Obter os valores cadastrados das inputs
 * 
 * @param  mixed $field_name - Atributo 'name' do campo na input
 * @return void
 */
function get_preserved_field($field_name) {
  return get_user_meta(get_current_user_id(), $field_name, true);
}

/**
 * 
 * Preservar valor padrão dos campos abaixo, eles nao podem ser altedos pelo usuario
 * 
 */
add_filter('default_checkout_billing_persontype', function () {
  return check_field_persontype(); 
}); 


/**
 * 
 * Disabilitar inputs no formulário que nao podem ser alteradas
 * 
 */
add_action('woocommerce_form_field_args', 'disable_select_persontype', 10, 3);
function disable_select_persontype($args, $key, $value)
{

  // Manter somente a opção selecionada
  if ($key == 'billing_persontype') {
    if (get_preserved_field('tipo_cadastro') == 'pessoa_juridica') {
      $args['options'] = array(check_field_persontype() => 'Pessoa Jurídica');
    } else {
      $args['options'] = array(check_field_persontype() => 'Pessoa Física');
    }
  }

  if ($key == 'billing_persontype' && !empty($value) 
  || $key == 'billing_cnpj' && !empty($value) 
  || $key == 'billing_company' && !empty($value)) {
    $args['custom_attributes'] = [
      'readonly' => 'readonly',
      'style' => 
        'user-select: none;
         cursor: default;
         border: none;
         box-shadow: none;
         appearance: none;
         padding: 0;
         font-weight: bold;
         pointer-events: unset;'
    ];
  }

  return $args;
}

/**
 * 
 * Validar se os campos que não podem ser alterados, foram alterados.
 * Checkout
 * 
 */
add_action( 'woocommerce_after_checkout_validation', 'custom_checkout_validation', 9999, 2);
function custom_checkout_validation( $fields, $errors ) {

  // if any validation errors
  if ( $fields['billing_persontype'] !=  get_preserved_field('billing_persontype') ) {
    $errors->add( 'validation', 'Você não pode alterar <b>Tipo de pessoa</b>, entre em contato com a loja para solicitar a mudança.' );
  }

  if (get_preserved_field('tipo_cadastro') == 'pessoa_juridica') {
    // Limpa a mascara caso houver
    $cnpj           = preg_replace('/[\/\-.]/', '', $fields['billing_cnpj']);
    $preserved_cnpj = preg_replace('/[\/\-.]/', '', get_preserved_field('billing_cnpj'));

    if (empty($cnpj)) {
      $errors->add( 'validation', 'O campo <b>CNPJ</b> não pode ser vazio.' );

    } elseif ( !empty($preserved_cnpj) && $cnpj !=  $preserved_cnpj ) {
      $errors->add( 'validation', 'Você não pode alterar o <b>CNPJ</b>, entre em contato com a loja para solicitar a mudança.' );
    }

    if ( empty($fields['billing_company']) ) {
      $errors->add( 'validation', 'O campo <b>Nome da empresa</b> não pode ser vazio.' );

    } elseif ( !empty(get_preserved_field('billing_company')) && $fields['billing_company'] != get_preserved_field('billing_company') ) {
      $errors->add( 'validation', 'Você não pode alterar <b>Nome da empresa</b>, entre em contato com a loja para solicitar a mudança.' );
    }
  }
} 

/**
 * 
 * Validar se os campos que não podem ser alterados, foram alterados.
 * Edit Address / Billing
 * 
 */
add_action( 'woocommerce_after_save_address_validation', 'custom_shipping_validation' );
function custom_shipping_validation() {

	// if any validation errors
  if ( $_POST['billing_persontype'] !=  get_preserved_field('billing_persontype') ) {
    wc_add_notice( 'Você não pode alterar <b>Tipo de pessoa</b>, entre em contato com a loja para solicitar a mudança.', 'error' );
  }

  if (get_preserved_field('tipo_cadastro') == 'pessoa_juridica') {

    $cnpj           = preg_replace('/[\/\-.]/', '', $_POST['billing_cnpj']);
    $preserved_cnpj = preg_replace('/[\/\-.]/', '', get_preserved_field('billing_cnpj'));

    if (empty($cnpj)) {
      wc_add_notice( 'O campo <b>CNPJ</b> não pode ser vazio.', 'error' );

    } elseif ( !empty($preserved_cnpj) && $cnpj !=  $preserved_cnpj ) {
      wc_add_notice( 'Você não pode alterar o <b>CNPJ</b>, entre em contato com a loja para solicitar a mudança.', 'error' );
    }

    if ( empty($_POST['billing_company']) ) {
      wc_add_notice( 'O campo <b>Nome da empresa</b> não pode ser vazio.', 'error' );

    } elseif ( !empty(get_preserved_field('billing_company')) && $_POST['billing_company'] != get_preserved_field('billing_company') ) {
      wc_add_notice( 'Você não pode alterar <b>Nome da empresa</b>, entre em contato com a loja para solicitar a mudança.', 'error' );
    }
  }
}

/**
 * 
 * Altera o valor do perço no carrinho
 * 
 */
add_filter('woocommerce_cart_item_price', 'bbloomer_change_cart_table_price_display', 30, 3);
function bbloomer_change_cart_table_price_display($price, $values, $cart_item_key)
{
  $slashed_price = $values['data']->get_price_html();
  $is_on_sale = $values['data']->is_on_sale();

  if ($is_on_sale) {
    $price = $slashed_price;
  }
  return $price;
}

/**
 * 
 * Ações depois que Criar ou atualizar o produto pelo REST API
 * 
 */
add_action('rest_insert_product', 'rest_insert_product_meta', 10, 3);
function rest_insert_product_meta(\WP_Post $post, $request, $creating)
{
  $metas = $request->get_param("meta");

  if (is_array($metas)) {
    foreach ($metas as $name => $value) {
      update_post_meta($post->ID, $name, $value);
    }
  }
}

/**
 * 
 * Cria o campo do preço atacadista
 * 
 */
// add_action('init', 'register_product_meta');
// function register_product_meta()
// {
//   register_post_meta(
//     'product',
//     '_wc_wholesaler_regular_price',
//     array(
//       'single'       => true,
//       'type'         => 'string',
//       'default'      => '',
//       'show_in_rest' => true,
//     )
//   );
// };


/**
 * Incluir os outros arquivos da pasta wholesaler/
 */

require 'prices-shop.php';
require 'payment.php';
require 'simple-product-pricing.php';
require 'variations-product-pricing.php';
require 'update-simple-product-pricing.php';
require 'update-variations-product-pricing.php';