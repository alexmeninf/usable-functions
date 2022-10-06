jQuery(function ($) {
  var drawerClass = '.drawer', drawerId;

  drawerMobile = () => {
    const drawerButton = '.drawerButton',
      drawerClose = '.close-menu',
      drawerClosed = 'drawerClosed',
      drawerOpen = 'drawerOpen',
      listMenu = '.drawer .sidebar-links',
      submenu = '.sub-menu',
      iconAnimate = 'rotateIcon';

    function openMenuSwiped() {
      const direction = $(drawerClass).attr('data-drawer-direction') || 'left';

      $('body').css('overflow', 'hidden');

      if ($('.backdrop-layer').length == 0) {
        $("body").append('<div class="backdrop-layer"></div>');
        $('.backdrop-layer').fadeIn(300);
      }

      $(drawerClass).removeClass(drawerClosed);
      $(drawerClass).addClass(drawerOpen);

      if (direction == 'right') {
        $(drawerClass).css({ right: 0 });
      } else {
        $(drawerClass).css({ left: 0 });
      }

      $(drawerButton + '[data-drawer-id=' + drawerId + ']').css({ transform: 'translateX(7px)', opacity: 0, transition: '.3s ease-in' });

      setTimeout(() => {
        $(drawerClose).addClass('open');
      }, 200);
    }

    function closeMenuSwiped() {
      const direction = $(drawerClass).attr('data-drawer-direction') || 'left';
      const timeout = $(drawerButton).attr('data-drawer-timeout') || 600;

      $('body').css('overflow', '');
      $('.backdrop-layer').fadeOut(300, function () { $(this).remove(); });
      $(drawerClose).removeClass('open');

      if (direction == 'right') {
        $(drawerClass).css({ right: '-100%' });
      } else {
        $(drawerClass).css({ left: '-100%' });
      }

      $(drawerButton + '[data-drawer-id=' + drawerId + ']').css({ transform: 'translateX(0)', opacity: 1 });

      setTimeout(() => {
        $(drawerClass).addClass(drawerClosed);
        $(drawerClass).removeClass(drawerOpen);
        $(drawerClass + ' .searchfield_cancel').removeClass('active-btn');
      }, timeout);
    }

    // Open
    $(drawerButton).click(function (e) {
      e.preventDefault();
      drawerId = $(this).attr('data-drawer-id');
      drawerClass = '.drawer';
      drawerClass = '#' + drawerId + drawerClass;
      openMenuSwiped();
    });

    // close and open submenu
    $(listMenu + " .menu-item-has-children > a," + drawerClose).click(function (e) {
      e.preventDefault();

      let parentLi = $(this).parent('li');
      let hasSubmenu = $(this).parents('li');

      if (parentLi.find(submenu).length) {
        hasSubmenu.siblings().find(submenu).slideUp();
        parentLi.find('>' + submenu + ' ul').slideUp();
        parentLi.find('>' + submenu).slideToggle();
        hasSubmenu.siblings().find('> a > i').removeClass(iconAnimate);
        $(this).find('i').toggleClass(iconAnimate);

        hasSubmenu.siblings().removeClass('active');
        hasSubmenu.siblings().find('li').removeClass('active');
        parentLi.find('li').removeClass('active');

        if (parentLi.hasClass('active')) {
          parentLi.removeClass('active');
        } else {
          parentLi.addClass('active');
        }

        return false;

      } else {
        $(listMenu + ' li').find(submenu).slideUp();
        $(listMenu + ' li').find('i').removeClass(iconAnimate);
        closeMenuSwiped();
      }
    });

    // Anchor empty
    $(listMenu + ' a[href*="#"]').click(function(e) {
      e.preventDefault();
      closeMenuSwiped();      
    })

    // Search form
    $('.wrapper-form .searchfield_cancel').on('click', function () {
      $(this).removeClass('active-btn');
      $('.wrapper-form .search-field').val('');
    });

    $('.wrapper-form .search-field').on('click', function () {
      if (isMobile()) {
        console.log($(this).closest('.wrapper-form'))
        $(this).closest('.wrapper-form').find('.searchfield_cancel').addClass('active-btn');
      }
    });
  }

  drawerMobile();
});
