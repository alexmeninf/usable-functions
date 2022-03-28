jQuery(function ($) {

  // remove item in cart
  $(document).on('click', '.remove-from-cart', function (e) {
  	e.preventDefault();

  	let ajaxurl    = $('meta[name=urlajax]').attr('content');
  		themeroot    = $('meta[name=themeroot]').attr('content'),
  		cartItems    = $(this).parent().parent(),
			cartShopping = '#miniCart .cart-fragments',
			totalItems   = '.mini-cart-count .cart_contents_count',
			symbol       = $(cartShopping).data('currency-symbol');
  		item         = $(this).parent();

  	$(item).addClass('loading-removing');
		$(cartShopping + ' li > .remove-from-cart').css({pointerEvents: 'none', opacity: '0.4'});
		
  	$.ajax({
  		type: "POST",
  		url: wc_add_to_cart_params.ajax_url,
  		data: {
  			action: 'remove_item_from_cart',
  			'cart_item_key': String(item.data('cart-item-key'))
  		},
  		success: function (res) {
  			if (res) {
  				// Subtrai total de items
          let countItems = parseInt($(totalItems).html()), //qnt total
  					qnt          = item.find('.qnt').html(); // qnt item removed

  				$(totalItems).html(countItems - qnt);

          // Subtrai valor total
          let currentTotal = parseFloat($(cartShopping).attr('data-totals-cart')),
            priceRemoved   = parseFloat(item.find('.mini-cart__product__quantity').attr('data-total-price')),
            newTotalPrice  = currentTotal - priceRemoved;
          $(cartShopping).attr('data-totals-cart', parseFloat(newTotalPrice).toFixed(2));

          // Formartted price
          newTotalPrice = newTotalPrice.formatMoney(2, symbol + " ", ".", ",");
          $('.mini-cart__total span.ammount').html(newTotalPrice);

					
          // remove item
  				$(cartShopping + ' .mini-cart__product[data-cart-item-key=' + item.data('cart-item-key') + ']').remove();

  				// if empty, show message
  				if (cartItems.has('.mini-cart__product').length == 0) {

  					$(cartShopping + ' .mini-cart__list').html('<li class="empty-cart-txt"><span class="d-block my-4">Seu carrinho está vazio!</span></li>');

  					$('.mini-cart__total span.ammount').html(symbol + ' 00,00');

						$('.mini-cart__buttons').html(`<a href="${ajaxurl}/loja" class="btn-theme btn-medium">Fazer compras</a>`);
  				}

  				Swal.fire({
  					icon: 'success',
  					title: 'Item removido do carrinho'
  				});

					$(item).removeClass('loading-removing');
					$(cartShopping + ' li > .remove-from-cart').css({pointerEvents: '', opacity: ''});

  				// reload cart page to update data
  				if (document.location.href == ajaxurl + '/carrinho/' || document.location.href == ajaxurl + '/finalizar-compra/') {
  					location.reload();
  				}
  			}
  		},
  		error: function (res) {
  			if (res) {
  				$(item).removeClass('loading-removing');
					$(cartShopping + ' li > .remove-from-cart').css({pointerEvents: '', opacity: ''});

  				Swal.fire({
  					title: 'Algo deu errado',
  					titleText: 'O item não foi removido por algum motivo. Tente novamente mais tarde.',
  					icon: 'error',
  					confirmButtonText: 'Fechar'
  				});
  			}
  		}

  	});
  });
});
  
Number.prototype.formatMoney = function (places, symbol, thousand, decimal) {
  places = !isNaN(places = Math.abs(places)) ? places : 2;
  symbol = symbol !== undefined ? symbol : "R$";
  thousand = thousand || ",";
  decimal = decimal || ".";
  let initialDiv = '<span class = "woocommerce-Price-amount amount" >';
  let finalDiv = '</span>';

  var number = this,
    negative = number < 0 ? "-" : "",
    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
  return initialDiv + symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "") + finalDiv;
};
