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