  drawerMobile = () => {
    let drawer = '.drawer-mobile',
      drawerButton = '.drawerButton',
      drawerClose = '.close-menu',
      drawerClosed = 'drawerClosed',
      drawerOpen = 'drawerOpen',
      listMenu = '.drawer-mobile .wrap',
      submenu = '.submenu',
      iconAnimate = 'rotateIcon';

    function openMenuSwiped() {
      $('body').css('overflow', 'hidden');
      $(drawer).removeClass(drawerClosed);
      $(drawer).addClass(drawerOpen);
      $(listMenu).animate({
        left: '0'
      });
      setTimeout(() => {
        $(drawerClose).addClass('open');
      }, 200);
    }

    function closeMenuSwiped() {
      $('body').css('overflow', '');
      $(drawerClose).removeClass('open');
      $(listMenu).animate({
        left: '-100%'
      });
      setTimeout(() => {
        $(drawer).addClass(drawerClosed);
        $(drawer).removeClass(drawerOpen);
      }, 600);
    }

    // Open
    $(drawerButton).click(function (e) {
      e.preventDefault();
      openMenuSwiped();
    });

    // close and open submenu
    $(listMenu + " ul > li > a," + drawerClose).click(function () {
      let parentLi = $(this).parent('li');
      let hasSubmenu = $(this).parents('li');

      if (parentLi.find(submenu).length) {
        hasSubmenu.siblings().find(submenu).slideUp();
        parentLi.find('>' + submenu).slideToggle();
        hasSubmenu.siblings().find('> a > i').removeClass(iconAnimate);
        $(this).find('i').toggleClass(iconAnimate);
        return false;

      } else {
        $(listMenu + '> li').find(submenu).slideUp();
        $(listMenu + '> li').find('i').removeClass(iconAnimate);
        closeMenuSwiped();
      }
    });

    document.addEventListener('swiped-right', function (e) {
      openMenuSwiped();
    });

    document.getElementById('drawer').addEventListener('swiped-left', function (e) {
      closeMenuSwiped();
    });
  }
