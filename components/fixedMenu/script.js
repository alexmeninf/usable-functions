headerFix = () => {
  let fixColor = "new-bg",
    $header = $(".fixed-header");

  function checkHeader() {
    if ($(this).scrollTop() > 100) {
      $header.addClass(fixColor + " wow fadeInDown animated");
    } else {
      $header.removeClass(fixColor + " wow fadeInDown animated");
    }
  }

  $(window).ready(function () {
    checkHeader();
  });

  $(window).scroll(function () {
    checkHeader();
  });
}