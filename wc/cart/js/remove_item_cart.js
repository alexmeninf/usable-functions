// remove item in cart
$('.remove-item').click(function (e) {
	e.preventDefault();
	let ajaxurl = $('meta[name=urlajax]').attr('content');
	let parentItem = $(this).parent();
	let parentItem2 = $(this).parent().parent();

	$(parentItem).addClass('loading');

	$.ajax({
		type: "POST",
		url: wc_add_to_cart_params.ajax_url,
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
		},
		error: function (res) {
			if (res) {
				$(parentItem).removeClass('loading');

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