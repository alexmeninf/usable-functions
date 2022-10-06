jQuery(function ($) {

  // Menu fixo
  fixedMenu = () => {
    let header = $(".fixed-header"), offset = $(window).height(), lastScrollTop = 0;

    function checkHeader() {
      let st = $(this).scrollTop();

      if (st > lastScrollTop) {
        if (st > offset) {
          header.addClass('hide-menu');
        }
      } else {
        header.removeClass('hide-menu');
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
    let listMenu = '.header-menu',
      iconAnimate = 'rotateIcon',
      submenu = '.sub-menu';

    var direction = 'right';
    var directionH = 'bottom';

    // Add arrow element to the parent li items and chide its child uls
    $('.menu-main').find('li ul').each(function () {
      var sub_ul = $(this),
        parent_a = sub_ul.prev('a'),
        parent_li = parent_a.parent('li').first();

      if (parent_li.hasClass('menu-item-has-children')) {
        let ahref = parent_a.attr('href'),
          aTitle = parent_a.html(),
          clone = parent_a.attr('data-clone'),
          text = parent_a.attr('data-text');

          if (window.innerWidth < 1200) {
            parent_a.append('<i class="fa-light fa-angle-right ms-2 me-0"></i>');
          } else {
            parent_a.append('<i class="fa-light fa-angle-down ms-2 me-0"></i>');
          }
        parent_a.attr('href', 'javascript:void(0)');

        // Adiciona uma nova li com o link do item pai
        if (clone == 'true' || clone == 'yes') {
          let pnext = parent_a.next(submenu),
          t = text == undefined ? aTitle : text;
          $('<li><a href="' + ahref + '">' + t + '</a></li>').prependTo(pnext);
        }
      }
    });

    $(listMenu + " .menu-item-has-children > a").click(function (e) {
      e.preventDefault();

      const parentLi = $(this).parent('li');
      const hasSubmenu = $(this).parents('li');

      if (parentLi.find(submenu).length) {
        const el = parentLi.find('>' + submenu);
        const elNext = parentLi.find('>' + submenu + '> .hasChild > ' + submenu);
        const idEl = el.attr('id');

        hasSubmenu.siblings().find(submenu).slideUp(200);
        parentLi.find('>' + submenu + ' ul').slideUp(200);
        parentLi.find('>' + submenu).slideToggle(200);
        // hasSubmenu.siblings().find('> a > i').removeClass(iconAnimate);
        // parentLi.find('li a > i').removeClass(iconAnimate);

        // $(this).find('i').toggleClass(iconAnimate);

        hasSubmenu.siblings().removeClass('active');
        hasSubmenu.siblings().find('li').removeClass('active');
        parentLi.find('li').removeClass('active');

        if (parentLi.hasClass('active')) {
          parentLi.removeClass('active');
        } else {
          parentLi.addClass('active');
        }

        // Verifica se o submenu ultrapassar a tela na horizontal, mudar direção
        const p = document.getElementById(idEl).getBoundingClientRect();
        const w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        const h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
        const elW = Math.ceil(p.width);
        const elH = Math.ceil($('#' + idEl).innerHeight());

        if (!parentLi.parent().hasClass('nav-list-desktop')) {
          const l1 = 'calc(-100% - (-45px))',
            l2 = 'calc(100% - 45px)';

          const t1 = 'calc(55% - ' + elH + 'px)',
            t2 = '100%';

          // Quebra na direita
          if ((p.left + elW) > w) {
            direction = 'left';
            el.css({ left: l1 });
            elNext.css({ left: l1 });

            // Quebra na esquerda
          } else if (p.left < 0) {
            direction = 'right';
            el.css({ left: l2 });
            elNext.css({ left: l2 });

            // Direção normal pra esqueda
          } else if (direction == 'left') {
            el.css({ left: l1 });
            elNext.css({ left: l1 });

          } else {
            el.css({ left: l2 });
            elNext.css({ left: l2 });
          }

          // Quebra em baixo
          if ((p.top + elH) > h) {
            directionH = 'top';
            el.css({ top: t1 });
            elNext.css({ top: t1 });

            // Quebra em cima
          } else if (p.top < 0) {
            directionH = 'bottom';
            el.css({ top: t2 });
            elNext.css({ top: t2 });

            // Direção normal pra cima
          } else if (directionH == 'top') {
            el.css({ top: t1 });
            elNext.css({ top: t1 });

          } else {
            el.css({ top: t2 });
            elNext.css({ top: t2 });
          }
        }

        return false;
      } else {
        $(listMenu + ' li').find(submenu).slideUp(200);
        // $(listMenu + ' li').find('i').removeClass(iconAnimate);
      }
    });
  }

  function searchOpen() {
    $('.cta-search').on('click', function () {
      $('.nav-list-desktop').toggleClass("visibility-menu");
      $('.fixed-header .search-form').toggleClass("visibility-search");
      $(this).find('i').toggleClass('fa-xmark');
      $(this).toggleClass('active');
    })
  }

  fixedMenu();
  adjustOpeningSubmenu();
  searchOpen();
});
