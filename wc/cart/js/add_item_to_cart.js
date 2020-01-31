// add to cart			
$('.add_to_cart_button').on('click', function (e) {
  e.preventDefault();
  let countClass = '.icon-cart span';
  let oldValue = $(countClass).html();
  let ajaxurl = $('meta[name=urlajax]').attr('content');

  oldValue = parseInt(oldValue) + 1;
  $(countClass).html(oldValue);

  setTimeout(() => {
    if ($('.cart-fragments').has('li').length > 0) {
      $('.btn-cart').html(
        `<a href="${ajaxurl}/carrinho/" class="view-cart">Ver Carrinho</a>
        <a href="${ajaxurl}/finalizar-compra/" class="check-out">Finalizar Compra</a>`);
    }
  }, 1200);
});