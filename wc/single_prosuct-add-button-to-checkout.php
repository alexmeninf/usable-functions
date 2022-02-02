<?php
/**
 * Redireciona o produto direto para a página de checkout
 */

function add_content_after_addtocart()
{
  if ( ! is_product()) return;
  
  $current_product_id = get_the_ID();
  $product = wc_get_product($current_product_id);

  if (is_user_logged_in() && ($product->is_type('simple') || $product->is_type('variable'))) :
  ?>

  <div class="d-flex">
     <button type="button" class="to-checkout-product single_add_to_cart_button button alt <?php $product->is_type('variable') ? 'disabled wc-variation-selection-needed' : '' ?>" style="background-color: #262626;border-color: #262626">Finalizar Pedido</button>
  </div>

  <?php
  endif; 
}

add_action('woocommerce_after_add_to_cart_button', 'add_content_after_addtocart');


function add_script_single_product() 
{
  if ( ! is_product()) return;

  $current_product_id = get_the_ID();
  $product = wc_get_product($current_product_id);
  ?>

  <script type="text/javascript">
    jQuery(function($) {
      $('button.to-checkout-product').on('click', function(e) {
        e.preventDefault();

        let dataProduct = $('.summary form.cart').serialize();

        <?php if ($product->is_type('simple')) : ?>
        window.location.href = '<?php echo WC()->cart->get_checkout_url() ?>?add-to-cart=<?= get_the_ID(); ?>&' + dataProduct;
        <?php elseif ($product->is_type('variable')) : ?>
        window.location.href = '<?php echo WC()->cart->get_checkout_url() ?>?' + dataProduct;
        <?php endif; ?>
      });
    });
  </script>
<?php
}

add_action('wp_footer', 'add_script_single_product', 100);
