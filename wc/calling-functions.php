<?php

// get shop link
get_permalink( woocommerce_get_page_id( 'shop' ) );

// get cart content and count
WC()->cart->get_cart_contents_count();

// get cart total value
WC()->cart->total;

// get cart url
wc_get_cart_url();

// check if the user is logged in
is_user_logged_in();
