/**
 * Checks if it is an iOS device
 */
iOSDevice() {
  const isIOS    = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent);
  const isMacOS  = navigator.platform.indexOf('Mac') != -1;
  const isSafari = navigator.platform.indexOf('Safari') != -1;

  if (isIOS || isMacOS || isSafari) {
    return true;
  }

  return false;
}

jQuery(function () {
  function iOSEmbed() {
    if (iOSDevice()) {
      $('.embed-video').addClass('iOS');
    }
  }

  iOSEmbed();
});
