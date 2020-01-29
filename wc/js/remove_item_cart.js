// remove item in cart
$('BUTTON_TO_REMOVE_HERE').click(function (e) {
  e.preventDefault();
  let ajaxurl = $('meta[name=urlajax]').attr('content'); // create meta with url site
  let parentItem = $(this).parent(); // get wrap element
  let parentItem2 = $(this).parent().parent(); // get the wrap parent Ex: <ul>

  $(parentItem).addClass('loading');

  $.ajax({
    type: "POST",
    url: ajaxurl + '/wp-admin/admin-ajax.php',
    data: {
      action: 'remove_item_from_cart',
      'cart_item_key': String($(this).data('cart-item-key'))
    },
    success: function (res) {
      if (res) {
        let countItems = parseInt($('.icon-cart span').html()); //qnt total
        let qnt = parentItem.find('.price .qnt').html(); // qnt item removed
        $('.icon-cart span').html(countItems - qnt);

        // remove item
        $('.dropdown-box ul li[data-id=' + parentItem.attr('data-id') + ']').remove();

        // if empty, show message
        if (parentItem2.has('li').length == 0) {
          $('.dropdown-box ul').html('<li class="empty-cart-txt">Seu Carrinho está Vazio!</li>');
          $('.btn-cart').html(`<a href="${ajaxurl}/loja" class="view-cart">Fazer compras</a>`);
          $('.total .price, .price-cart').html('R$ 00,00');
        }

        Swal.fire({
          type: 'success',
          title: 'Item removido do carrinho'
        });

        // reload cart page to update data
        if (document.location.href == ajaxurl + '/carrinho/') {
          document.location.reload(true);
        }
      }
    }
  });
});


// PHP FUNCTION 
// function remove_item_from_cart() {
//   $cart_item_key = $_POST['cart_item_key'];
//   if($cart_item_key){
//      WC()->cart->remove_cart_item($cart_item_key);
//      return true;
//   } 
//   return false;
// }
// add_action('wp_ajax_remove_item_from_cart', 'remove_item_from_cart');
// add_action('wp_ajax_nopriv_remove_item_from_cart', 'remove_item_from_cart');
