<?php
/**
 * Redireciona o produto direto para a página de checkout
 */

function add_content_after_addtocart()
{
  if ( ! is_product()) return;
  
  $current_product_id = get_the_ID();
  $product = wc_get_product($current_product_id);

  if (is_user_logged_in() && WC()->cart->get_cart_contents_count() > 0 ) : ?>
  
    <button type="button" 
    class="to-checkout-product single_add_to_cart_button button <?php $product->is_type('variable') ? 'disabled wc-variation-selection-needed' : '' ?>"
    ><?php _e('Finalizar Pedido', 'wcstartertheme') ?></button>

  <?php
  endif; 
}

add_action('woocommerce_after_add_to_cart_button', 'add_content_after_addtocart');


function add_script_single_product() 
{
  if ( ! is_product()) return; ?>

  <script type="text/javascript">
    jQuery(function($) {
      $('button.to-checkout-product').on('click', function(e) {
        e.preventDefault();

        window.location.href = '<?php echo WC()->cart->get_checkout_url() ?>';

      });
    });
  </script>

<?php
}

add_action('wp_footer', 'add_script_single_product', 100);
