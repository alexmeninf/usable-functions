drawerMobile = () => {
  let drawer = '.drawer-mobile',
    drawerButton = '.drawerButton',
    drawerClose = '.close-menu',
    listMenu = '.drawer-mobile ul';

  // Open
  $(drawerButton).click(function (e) {
    e.preventDefault();

    $('body').css('overflow', 'hidden');
    $(drawer).removeClass('drawerClosed');
    $(drawer).addClass('drawerOpen');
    $(listMenu).animate({
      left: '0'
    });
    setTimeout(() => {
      $(drawerClose).addClass('open');
    }, 200);
  });

  // close
  $('.drawer-mobile ul li a, .close-menu').click(function () {
    $('body').css('overflow-y', 'scroll');
    $(drawerClose).removeClass('open');
    $(listMenu).animate({
      left: '-100%'
    });
    setTimeout(() => {
      $(drawer).addClass('drawerClosed');
      $(drawer).removeClass('drawerOpen');
    }, 600);
  });
}