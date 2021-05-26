  // remove item in cart
  $(document).on('click', '.remove-item', function (e) {
    e.preventDefault();

    let ajaxurl = $('meta[name=urlajax]').attr('content');
    let themeroot = $('meta[name=themeroot]').attr('content');
    let parentItem = $(this).parent().parent();
    let parentItem2 = $(this).parent().parent().parent();

    $.ajax({
      type: "POST",
      url: wc_add_to_cart_params.ajax_url,
      data: {
        action: 'remove_item_from_cart',
        'cart_item_key': String($(this).data('cart-item-key'))
      },
      success: function (res) {
        if (res) {
          let countItems = parseInt($('.cart_contents_count.calc').html()); //qnt total de itens no carrinho
          let qnt = parseInt(parentItem.find('.qty').html()); // qnt de itens removidos do produto atual
          let totalItems = countItems - qnt;

          $('.cart_contents_count').html(totalItems); // atualizar no header o total de items no carrinho

          // remove item selecionado
          $('.cart_list li[data-id=' + parentItem.attr('data-id') + ']').remove();

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

          // Atualiza preço total de items no carrinho
          let totalPrice = 0;
          $('.cart-fragments li .price').each(function () {
            totalPrice = totalPrice + parseFloat($(this).attr("data-total-price"));
          });
          $('.total-minicart .amount').html(totalPrice.formatMoney(2, "R$ ", ".", ","));
          $('.cart-fragments').attr('data-totals-cart', totalPrice);

          // if empty, show message
          if (parentItem2.has('li').length == 0) {
            $('.cart_list').html('<li class="empty-cart-txt">Seu Carrinho está vazio!</li>');
            $('.buttons').html(`<a href="${ajaxurl}/loja" class="btn pull-left btn-minicart">Fazer compras</a>`);
          }

          Swal.fire({
            type: 'success',
            title: 'Item removido do carrinho'
          });

          // reload cart page to update data
          if (document.location.href == ajaxurl + '/carrinho/' || document.location.href == ajaxurl + '/finalizar-compra/') {
            document.location.reload(true);
          }
        }
      },
      error: function (res) {
        if (res) {
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
