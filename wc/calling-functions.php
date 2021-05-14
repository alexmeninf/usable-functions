<?php
// FUNCTION
is_user_logged_in(); // verifica se o usuario esta logado


// CART
//
// get cart content and count
WC()->cart->get_cart_contents_count();

// get cart total value
WC()->cart->total;

// Price format
wc_price( WC()->cart->total, array(false, '', ',', '.') ) ;


// URLS
//
// Use get_permalink
$endpoints = array(
  'orders'          => get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' ),
  'downloads'       => get_option( 'woocommerce_myaccount_downloads_endpoint', 'downloads' ),
  'edit-address'    => get_option( 'woocommerce_myaccount_edit_address_endpoint', 'edit-address' ),
  'payment-methods' => get_option( 'woocommerce_myaccount_payment_methods_endpoint', 'payment-methods' ),
  'edit-account'    => get_option( 'woocommerce_myaccount_edit_account_endpoint', 'edit-account' ),
  'customer-logout' => get_option( 'woocommerce_logout_endpoint', 'customer-logout' ),
);

// account page
get_permalink( get_option('woocommerce_myaccount_page_id');

// lista de desejos plugin
get_permalink(get_option( 'yith_wcwl_wishlist_page_id' );
              
/// checkout
wc_get_checkout_url();

// get cart url
wc_get_cart_url();

// check if the user is logged in
is_user_logged_in();
              
// get shop link
get_permalink( woocommerce_get_page_id( 'shop' ) );
