 buttonCart = () => {

    $('.product-item .compare-wishlist a').click(function () {
      let url = $('meta[name="urlajax"]').attr('content');

      $(this).html('<i class="fas fa-heart"></i> Adicionado a sua lista!');
      $(this).attr('href', url + '/lista-de-desejos');

      setTimeout(function () {
        return $(this).removeClass('add_to_wishlist');
      }, 1120);
    });

    $('.single_add_to_cart_button').html('<i class="fas fa-cart-plus" style="margin-right: 12px;"></i> Comprar');
    $('.yith-wcwl-icon.fa.fa-heart-o').addClass('fal fa-heart');
    $('.yith-wcwl-icon.fa.fa-heart-o').removeClass('yith-wcwl-icon fa fa-heart-o');
  }
  
  buttonCart();
