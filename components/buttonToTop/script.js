  btnToTop = () => {
    let offset = $(window).height() + 100,
      lastScrollTop = 0;

    function show_btn() {
      $('.btn-to-top').removeClass('hidden').addClass('visible');
    }

    function hide_btn() {
      $('.btn-to-top').removeClass('visible').addClass('hidden');
    }

    hide_btn();

    $(window).scroll(function () {
      let st = $(this).scrollTop();

      if (st > lastScrollTop) {
        if (st > offset) {
          show_btn();
        }
      } else {
        hide_btn();
      }
      lastScrollTop = st;
    });

    $(document).on('click', '.btn-to-top', function (e) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: 0
      }, 1200);

    });
  }