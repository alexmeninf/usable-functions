<ul class="cart-fragments" data-totals-cart="<?= WC()->cart->total ?>">
  <?php do_action( 'woocommerce_before_cart_contents' ); ?>
  <?php if(WC()->cart->is_empty()): ?>
    <li class="empty-cart-txt">Seu Carrinho está Vazio!</li>
  <?php else: ?>

    <?php
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

      $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
      $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

      if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );				
        $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
        $product_name      = apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
        $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
        $product_subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
        $attributes        = '';
        //Variation
        $attributes .= $_product->is_type('variable') || $_product->is_type('variation') ? wc_get_formatted_variation($_product) : '';
        // Meta data
        if(version_compare( WC()->version , '3.3.0' , "<" )){
          $attributes .=  WC()->cart->get_item_data( $cart_item );
        }
        else{
          $attributes .=  wc_get_formatted_cart_item_data( $cart_item );
        }
    ?>
        <li data-id="<?php echo $cart_item_key; ?>">
          <div class="img-product">
            <a href="<?php echo $product_permalink; ?>"><?php echo $thumbnail; ?></a>
          </div>
          <div class="info-product">
            <div class="name"><?php echo $product_name; ?></div><!-- /.name -->

            <?php echo $attributes ? $attributes : ''; ?> 

            <div class="price">
              <span class="qnt"><?php echo $cart_item['quantity']; ?></span> X <span><?php echo $product_price; ?></span> 
            </div><!-- /.price -->
          </div><!-- /.info-product -->

          <div class="clearfix"></div>
          <span class="delete remove-item" data-cart-item-key="<?=$cart_item_key;?>">x</span>
        </li>
      <?php } ?>
    <?php } ?>
  <?php endif; ?>
</ul>
