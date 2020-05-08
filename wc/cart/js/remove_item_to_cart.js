// remove item in cart
  $(document).on('click', '.remove-item', function (e) {
    e.preventDefault();

    let ajaxurl = $('meta[name=urlajax]').attr('content');
    let themeroot = $('meta[name=themeroot]').attr('content');
    let parentItem = $(this).parent();
    let parentItem2 = $(this).parent().parent();

    $(parentItem).find('.img-product').before(`<span class="loading"><img src="${themeroot}/img/loading.svg" alt="loading"></span>`);

    $.ajax({
      type: "POST",
      url: wc_add_to_cart_params.ajax_url,
      data: {
        action: 'remove_item_from_cart',
        'cart_item_key': String($(this).data('cart-item-key'))
      },
      success: function (res) {
        if (res) {
          let countItems = parseInt($('.count-cart span').html()); //qnt total
          let qnt = parseInt(parentItem.find('.price .qnt').html()); // qnt item removed
          let totalItems = countItems - qnt;

          $('.count-cart span').html(totalItems);

          // remove item
          $('.dropdown-box ul li[data-id=' + parentItem.attr('data-id') + ']').remove();

          // Update cart
          var data = {
            'action': 'mode_theme_update_mini_cart'
          };
          $.post(
            woocommerce_params.ajax_url, // The AJAX URL
            data, // Send our PHP function
            function (response) {
              $('.the_cart').html(response); // Repopulate the specific element with the new content
            }
          );

          //update total value
          let totalPrice = 0;
          $('.cart-fragments li .price').each(function () {
            totalPrice = totalPrice + parseFloat($(this).attr("data-total-price"));
          });
          $('.total .price-subtotal-cart').html(totalPrice.formatMoney(2, "R$ ", ".", ","));
          $('.cart-fragments').attr('data-totals-cart', totalPrice);

          // if empty, show message
          if (parentItem2.has('li').length == 0) {
            $('.dropdown-box ul').html('<li class="empty-cart-txt">Seu Carrinho está Vazio!</li>');
            $('.btn-cart').html(`<a href="${ajaxurl}/loja" class="view-cart">Fazer compras</a>`);
          }

          Swal.fire({
            type: 'success',
            title: 'Item removido do carrinho'
          });

          // reload cart page to update data
          if (document.location.href == ajaxurl + '/carrinho/' || document.location.href == ajaxurl + '/finalizar-compra/') {
            document.location.reload(true);
          }

          if (totalItems === 0) {
            return $('.total .price-subtotal-cart').html('R$ 0,00');
          }
        }
      },
      error: function (res) {
        if (res) {
          $(parentItem).find('.loading').remove();

          Swal.fire({
            title: 'Ops!',
            text: 'Algo deu errado, o item não removido. Tente novamente mais tarde.',
            type: 'error',
            confirmButtonText: 'Fechar'
          });
        }
      }

    });
  });
