  drawerMobile = () => {
    let drawer = '.drawer-mobile',
      drawerButton = '.drawerButton',
      drawerClose = '.close-menu',
      listMenu = '.drawer-mobile ul',
      submenu = '.submenu',
      drawerClosed = 'drawerClosed',
      drawerOpen = 'drawerOpen',
      swipeTouch = {};

    // Open
    $(drawerButton).click(function (e) {
      e.preventDefault();

      $('body').css('overflow', 'hidden');
      $(drawer).removeClass(drawerClosed);
      $(drawer).addClass(drawerOpen);
      $(listMenu).animate({
        left: '0'
      });
      setTimeout(() => {
        $(drawerClose).addClass('open');
      }, 200);
    });

    // close
    $(listMenu + '> li > a,' + drawerClose).click(function () {      
     let parentLi = $(this).parent('li');
     let hasSubmenu = $(this).parents('li');

      if (parentLi.find(submenu).length) {
        hasSubmenu.siblings().find(submenu).slideUp();
        parentLi.find('>' + submenu).slideToggle();
        return false;

      } else {
        $(listMenu + '> li').find(submenu).slideUp();
        $('body').css('overflow-y', 'scroll');
        $(drawerClose).removeClass('open');
        $(listMenu).animate({
          left: '-100%'
        });
        setTimeout(() => {
          $(drawer).addClass(drawerClosed);
          $(drawer).removeClass(drawerOpen);
        }, 600);
      }
    });

    if (!navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
      swipeTouch = document.getElementById('swipe-area');
    } else {
      swipeTouch = document;
    }

    swipeTouch.addEventListener('swiped-right', function (e) {
      $('body').css('overflow', 'hidden');
      $(drawer).removeClass(drawerClosed);
      $(drawer).addClass(drawerOpen);
      $(listMenu).animate({
        left: '0'
      });
      setTimeout(() => {
        $(drawerClose).addClass('open');
      }, 200);
    });

    document.getElementById('drawer').addEventListener('swiped-left', function (e) {
      $('body').css('overflow-y', 'scroll');
      $(drawerClose).removeClass('open');
      $(listMenu).animate({
        left: '-100%'
      });
      setTimeout(() => {
        $(drawer).addClass(drawerClosed);
        $(drawer).removeClass(drawerOpen);
      }, 600);
    });
  }
