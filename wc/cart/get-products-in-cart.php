<div class="mini-cart-inner cart-fragments"
 data-totals-cart="<?= disable_product_price() === false ? WC()->cart->total : '00.00' ?>" 
 data-currency-symbol="<?php echo get_woocommerce_currency_symbol(); ?>">
  <h3 class="mini-cart__heading">Carrinho</h3>
  <div class="mini-cart__content">
    <ul class="mini-cart__list">
      <?php if (WC()->cart->is_empty()) : ?>
        <li class="empty-cart-txt">
          <span class="d-block my-4"><?php _e('Seu carrinho está vazio!', 'menin') ?></span>
        </li>
        
      <?php else : ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
          $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
          $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

          if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :

            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key);
            $product_name      = apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_title()), $cart_item, $cart_item_key);
            $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
            $product_subtotal  = $cart_item['quantity'] * $cart_item['data']->get_price();
            $attributes        = '';
            //Variation
            $attributes .= $_product->is_type('variable') || $_product->is_type('variation') ? wc_get_formatted_variation($_product) : '';
            // Meta data
            if (version_compare(WC()->version, '3.3.0', "<")) {
              $attributes .=  WC()->cart->get_item_data($cart_item);
            } else {
              $attributes .=  wc_get_formatted_cart_item_data($cart_item);
            }
        ?>
            <li class="mini-cart__product item" data-cart-item-key="<?= $cart_item_key; ?>">
              <button class="remove-from-cart">
                remover
              </button>

              <div class="mini-cart__product__image">
                <img src="<?php echo wp_get_attachment_url($_product->get_image_id()); ?>" />
              </div>

              <div class="mini-cart__product__content">
                <a href="<?= $product_permalink; ?>" class="mini-cart__product__title">
                  <?= $product_name; ?>
                </a>

                <?php if ($attributes) : ?>
                  <div class="attributes">
                    <?= $attributes ?>
                  </div>
                <?php endif; ?>

                <span class="mini-cart__product__quantity" data-total-price="<?= disable_product_price() === false ? $product_subtotal : '00.00' ?>">
                  <span class="qnt"><?php echo $cart_item['quantity']; ?></span>
                  <?php
                  if (disable_product_price() === false) :
                    echo ' x <span class="amount">' . $product_price . '</span>';
                  else :
                    echo $cart_item['quantity'] == 1 ? ' item' : ' itens';
                  endif;
                  ?>
                </span>
              </div>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>

  <div class="mini-cart__total">
    <span>Subtotal</span>
    <span class="ammount">
      <?php echo get_woocommerce_currency_symbol(); ?>
      <?= disable_product_price() === false ? WC()->cart->total : '00,00' ?>
    </span>
  </div>

  <div class="mini-cart__buttons">
    <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
      <?php if (disable_product_price() === false) : ?>
        <a href="<?= wc_get_checkout_url() ?>" class="btn-theme btn-medium">
          <?= __('Finalizar Pedido', 'menin'); ?>
        </a>
      <?php endif; ?>
      <a href="<?= wc_get_cart_url(); ?>" class="btn-theme btn-theme-inverse btn-medium">
        <?= __('Ver Carrinho', 'menin'); ?>
      </a>
    <?php else : ?>
      <a href="<?= get_permalink(wc_get_page_id('shop')) ?>" class="btn-theme btn-medium">
        <?= __('Fazer compras', 'menin'); ?>
      </a>
    <?php endif; ?>
  </div>
</div>
