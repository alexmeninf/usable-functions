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
  && DISABLE_PRODUCT_PRICE_TO_CUSTOMER === true 
  && ! user_has_role('wholesaler') 
  || ! is_user_logged_in() ) {
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
    $price = __('Preço somente para atacadista', 'textdomain');
    $price .= ! is_user_logged_in() ? '<br><a class="fs-4" href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'">Acessar conta <i class="fal fa-sign-in"></i></a>' : '';
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
    $subtotal = __('Subtotal somente para atacadista', 'textdomain');
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
    $total = __('O valor só pode ser exibido após aprovação como atacadista cadastrado na loja.', 'textdomain');
  }

  return $total;
});


/**
 * 
 * Preço do produto no card, nao exibir para usuário comum, somente atacadista
 * 
 * */
function woocommerce_template_loop_price() {
	global $product;
	
	if (  user_has_role('wholesaler') ) {
    wc_get_template( 'loop/price.php' );
	} else {
    if (DISABLE_PRODUCT_PRICE_TO_CUSTOMER) {
      echo '<div style="height:40px;">&nbsp;</div>';
    } else {
      wc_get_template( 'loop/price.php' );
    }
	}
}


/**
 * 
 * Verifica se o preço atacadista tem desconto
 * 
 */
function is_on_sale_wholesaler($product_id, $context = 'view') {
  $product = wc_get_product( $product_id );

  if ( $product->is_type('simple') ) {
    $wholsaler_price      = get_post_meta($product_id, '_wc_wholesaler_regular_price', true);
    $wholsaler_sale_price = get_post_meta($product_id, '_wc_wholesaler_sale_price', true);
    
  } else {
    $wholsaler_price      = get_post_meta($product_id, '_wc_wholesaler_variation_price', true);
    $wholsaler_sale_price = get_post_meta($product_id, '_wc_wholesaler_variation_sale_price', true);
  }

  if ('' !== (string) $wholsaler_sale_price && (float) $wholsaler_price > (float) $wholsaler_sale_price ) {
    $on_sale = true;

    if ( $product->get_date_on_sale_from( $context ) && $product->get_date_on_sale_from( $context )->getTimestamp() > time() ) {
      $on_sale = false;
    }

    if ( $product->get_date_on_sale_to( $context ) && $product->get_date_on_sale_to( $context )->getTimestamp() < time() ) {
      $on_sale = false;
    }
  } else {
    $on_sale = false;
  }

  return 'view' === $context ? apply_filters( 'woocommerce_product_is_on_sale', $on_sale, $product ) : $on_sale;
}


/**
 * 
 * Atualiza o preço dos produto na loja
 * 
 * @version 1.0
 */
add_filter('woocommerce_get_price_html', 'change_product_price_display', 10, 2);

function change_product_price_display($price, $product)
{
  if (user_has_role('wholesaler')) {
    // Ajusta o preço pra produto simples
    if ( $product->is_type('simple') && $product->get_price() > 0) {
      $wholsaler_price = (float) get_post_meta($product->get_ID(), '_wc_wholesaler_regular_price', true);
      $wholsaler_sale_price = (float) get_post_meta($product->get_ID(), '_wc_wholesaler_sale_price', true);

      if ($product->is_on_sale() && get_option('wcj_price_by_user_role_enabled') == 'no') {
        $price = wc_price($product->get_price());

      } elseif ( is_on_sale_wholesaler($product->get_ID()) ) {
        $price = '<del>' . ((is_numeric($wholsaler_price)) ? wc_price($wholsaler_price) : $wholsaler_price) . '</del> <ins>' . ((is_numeric($wholsaler_sale_price)) ? wc_price($wholsaler_sale_price) : $wholsaler_sale_price) . '</ins>';
      }
    }

    // Ajusta o preço para produtos variaveis
    if ( $product->is_type('variation') ) {
      if ($product->get_price() > 0) {
        $wholsaler_price = (float) get_post_meta($product->get_ID(), '_wc_wholesaler_variation_price', true);
        $wholsaler_sale_price = (float) get_post_meta($product->get_ID(), '_wc_wholesaler_variation_sale_price', true);
        $from = $wholsaler_price;
        $to = (float) $product->get_price();

        if ($product->is_on_sale() && get_option('wcj_price_by_user_role_enabled') == 'yes') {
          $price = '<del>' . ((is_numeric($from)) ? wc_price($from) : $from) . '</del> <ins>' . ((is_numeric($to)) ? wc_price($to) : $to) . '</ins>';

        } elseif ( is_on_sale_wholesaler($product->get_ID()) ) {
          $price = '<del>' . ((is_numeric($from)) ? wc_price($from) : $from) . '</del> <ins>' . ((is_numeric($wholsaler_sale_price)) ? wc_price($wholsaler_sale_price) : $wholsaler_sale_price) . '</ins>';

        } else {
          $price = (is_numeric($wholsaler_price)) ? wc_price($wholsaler_price) : $wholsaler_price;
        }
      } else {
        $price = '<span>Grátis</span>';
      }

    } elseif( $product->is_type('variable') ) {
      $price = get_wholesaler_variation_prices($product);
    }
  }

  // Check stock
  if ($product->managing_stock() && !$product->is_in_stock() && !is_product()) {
    $price .= '<span class="d-block msg-stock">Fora de Estoque</span>';
  }

  return $price;
}