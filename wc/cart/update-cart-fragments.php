<?php

// update cart fragments
function meu_tema_add_to_cart_fragment( $fragments ) {
  ob_start();

  // content of cart
  get_template_part('inc/cart-content');

  $fragments['.cart-fragments'] = ob_get_clean();
  return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'meu_tema_add_to_cart_fragment' );


function mode_theme_update_mini_cart() {
  get_template_part('inc/header/cart-content');
  die();
}
add_filter( 'wp_ajax_nopriv_mode_theme_update_mini_cart', 'mode_theme_update_mini_cart' );
add_filter( 'wp_ajax_mode_theme_update_mini_cart', 'mode_theme_update_mini_cart' );