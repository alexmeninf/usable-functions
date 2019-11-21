$('.add_to_cart_button').on('click', function () {
  let countClass = 'CLASS_NAME';
  let oldValue = $(countClass).html();

  oldValue = parseInt(oldValue) + 1;
  $(countClass).html(oldValue);
});
