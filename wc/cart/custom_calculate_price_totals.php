<?php 

add_action('woocommerce_before_calculate_totals', 'custom_cart_items_prices', 10, 1);
function custom_cart_items_prices($cart)
{

  if (is_admin() && !defined('DOING_AJAX'))
    return;

  if (did_action('woocommerce_before_calculate_totals') >= 2)
    return;

  // Loop Through cart items
  foreach ($cart->get_cart() as $cart_item) {
    // Get the product id (or the variation id)
    $product_id = $cart_item['data']->get_id();

    // GET THE NEW PRICE (code to be replace by yours)
    $new_price = $cart_item['data']->get_regular_price() + 10; // <== Add your code HERE

    // Updated cart item price
    $cart_item['data']->set_price($new_price);
  }
}
