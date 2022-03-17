/**
 * Checks if it is an iOS device
 */
is_apple = () => {
  const isIOS = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent);
  const isMacOS = navigator.platform.indexOf("Mac") != -1;
  const isSafari = navigator.platform.indexOf("Safari") != -1;

  if (isIOS || isMacOS || isSafari) {
    return true;
  }

  return false;
};

/**
 * Checks if it is an mobile device
 */
is_mobile = () => {
  if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    return true;
  }
  return false;
};

/**
 * @param selectorItem Class or ID selector
 * @param breakpoint  Resolution at which the breakpoint happens
 */
autoHeight = (selectorItem, breakpoint) => {
  if ($(selectorItem).length) {
    let proposalHeight = 0;
    let top_of_element = $(selectorItem).offset().top;
    let bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();

    if ((bottom_of_screen > top_of_element)) {
      $(selectorItem).each(function () {
        if ($(this).innerHeight() > proposalHeight) {
          proposalHeight = $(this).innerHeight();
        }
      });

      if ($(document).innerWidth() >= breakpoint) {
        $(selectorItem).css("min-height", proposalHeight + "px");
      } else {
        $(selectorItem).css("min-height", "auto");
      }
    }
  }
};

// $(window).on("load", function () {
// });


// $(window).on("scroll", function () {
// });

// Get paramenters in URL
getParameterByName = (name, url = window.location.href) => {
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

