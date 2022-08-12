jQuery(function ($) {

  // Menu fixo
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


  // Ajusta a abertura do submenu de navegação.
  adjustOpeningSubmenu = () => {
    let fixedNavMenu = '.fixed-header .nav-list',
      listMenu = '.drawer-mobile .wrap',
      submenu = '.sub-menu';

    // Add arrow element to the parent li items and chide its child uls
    $('.header-menu').find('li ul').each(function () {
      var sub_ul = $(this),
        parent_a = sub_ul.prev('a'),
        parent_li = parent_a.parent('li').first();

      if (parent_li.hasClass('menu-item-has-children')) {
        let ahref = parent_a.attr('href'),
          aTitle = parent_a.text();

        parent_a.append('<i class="fal fa-sort-down ml-2"></i>');
        // Adiciona uma nova li com o link do item pai
        let pnext = parent_a.next(submenu);
        $('<li><a href="' + ahref + '"><span>Acessar ' + aTitle + '</span></a></li>').prependTo(pnext);
        // Remove o href para poder abrir o submenu
        parent_a.attr('href', 'javascript:void(0)');
      }
    });

    $(fixedNavMenu + " .menu-item-has-children > a").click(function (e) {
      let parentLi = $(this).parent('li');
      let hasSubmenu = $(this).parents('li');

      if (parentLi.find(submenu).length) {
        hasSubmenu.siblings().find(submenu).slideUp();
        parentLi.find('>' + submenu + ' ul').slideUp();
        parentLi.find('>' + submenu).slideToggle();
        return false;
      }
    });
  }

  fixedMenu();
  adjustOpeningSubmenu();
});
