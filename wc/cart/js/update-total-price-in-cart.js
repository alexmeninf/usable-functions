// update total price in cart
$("body").on('DOMSubtreeModified', ".cart-fragments", function() {
  $('.price-cart, .total > .price').html($('.cart-fragments').attr('data-totals-cart'));
});

// .cart-fragments => é o pai dos itens no carrinho