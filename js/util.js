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
