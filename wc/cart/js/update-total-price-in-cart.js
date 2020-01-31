Number.prototype.formatMoney = function (places, symbol, thousand, decimal) {
  places = !isNaN(places = Math.abs(places)) ? places : 2;
  symbol = symbol !== undefined ? symbol : "$";
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

// update total price in cart
$("body").on('DOMSubtreeModified', ".the_cart", function () {
  let getPrice = parseFloat($('.cart-fragments').attr('data-totals-cart'));
  getPrice = getPrice.formatMoney(2, "R$ ", ".", ",");
  return $('.price-cart, .total > .price').html(getPrice);
});

// .cart-fragments => é o pai dos itens no carrinho