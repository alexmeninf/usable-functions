fixedMenu = () => {
    let header = $(".fixed-header"), offset = $(window).height(), lastScrollTop = 0;
  
    function checkHeader() {
      let st = $(this).scrollTop();

      if (st > lastScrollTop) {
        if (st > offset) {
          header.addClass('hide');
        }
      } else {
        header.removeClass('hide');
      }
      lastScrollTop = st;
    }
  
    $(window).ready(function () {
      checkHeader();
    });
  
    $(window).scroll(function () {
      checkHeader();
    });
  }
