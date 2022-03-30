jQuery(function ($) {
  var drawerClass = '.drawer-mobile', drawerId;

  drawerMobile = () => {
    let drawerButton = '.drawerButton',
      drawerClose = '.close-menu',
      drawerClosed = 'drawerClosed',
      drawerOpen = 'drawerOpen',
      listMenu = '.drawer-mobile .wrap',
      submenu = '.sub-menu',
      iconAnimate = 'rotateIcon';

    function openMenuSwiped() {
      $('body').css('overflow', 'hidden');
      $(drawerClass).removeClass(drawerClosed);
      $(drawerClass).addClass(drawerOpen);
      $(listMenu).animate({
        left: '0'
      });

      $(drawerButton + '[data-drawer-id=' + drawerId + ']').css({transform: 'translateX(7px)', opacity: 0, transition: '.3s ease-in'});

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
      
      $(drawerButton + '[data-drawer-id=' + drawerId + ']').css({transform: 'translateX(0)', opacity: 1});

      setTimeout(() => {
        $(drawerClass).addClass(drawerClosed);
        $(drawerClass).removeClass(drawerOpen);
      }, 600);
    }

    // Open
    $(drawerButton).click(function (e) {
      e.preventDefault();
      drawerId = $(this).attr('data-drawer-id');
      drawerClass = '.drawer-mobile';
      drawerClass = '#' + drawerId + drawerClass;      
      openMenuSwiped();
    });

    // close and open submenu
    $(listMenu + " .menu-item-has-children > a," + drawerClose).click(function () {
      let parentLi = $(this).parent('li');
      let hasSubmenu = $(this).parents('li');

      if (parentLi.find(submenu).length) {
        hasSubmenu.siblings().find(submenu).slideUp();
        parentLi.find('>' + submenu + ' ul').slideUp();
        parentLi.find('>' + submenu).slideToggle();
        hasSubmenu.siblings().find('> a > i').removeClass(iconAnimate);
        $(this).find('i').toggleClass(iconAnimate);
        return false;

      } else {
        $(listMenu + ' li').find(submenu).slideUp();
        $(listMenu + ' li').find('i').removeClass(iconAnimate);
        closeMenuSwiped();
      }
    });

    // Search form
    $(drawerClass + ' .search-field').blur(function() {
      $(drawerClass + ' .searchfield_cancel').removeClass('active-btn');
    })
    .focus(function() {
      $(drawerClass + ' .searchfield_cancel').addClass('active-btn');
    });
  }

  drawerMobile();
});
