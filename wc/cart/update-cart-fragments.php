<?php
/**
 * 
 * Update cart fragments
 * Version 1.0
 * 
 */

function meu_tema_add_to_cart_fragment( $fragments ) { 
  ob_start(); ?>

  <span class="cart_contents_count"><?= WC()->cart->cart_contents_count ?></span>
  
  <?php 
  $fragments['.cart_contents_count'] = ob_get_clean();

  ob_start();

  // ATENÇÃO: Para ativar esta função, lembre de criar o diretório abaixo e o template
  get_template_part('template-parts/cart/cart-content');

  $fragments['.cart-fragments'] = ob_get_clean();
  return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'meu_tema_add_to_cart_fragment' );
