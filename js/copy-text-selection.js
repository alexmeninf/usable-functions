function copyTextSelection(el, text = 'Copiado!') {
  /* Get the text field */
  var copyText = document.getElementById(el);

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  /* Alert the copied text */
  alerts.alert({
    type: 'success',
    title: text,
    autoclose: 2000,
  });
}
