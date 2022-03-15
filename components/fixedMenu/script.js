// Submenu
!function(e,n){var i={init:function(n,i){var u=this;u.options=e.extend({},e.fn.nav.options,n),u.$body=e("body"),u.$nav=e(i),u.$menuButton=e(u.options.navButton),u.$subMenu=e(u.options.subMenu),u.subMenu=u.options.subMenu,u.mobileMode=u.isCurrentlyMobile(u),u.mouseOver=u.options.mouseOver,u.disableSubMenuLink=u.options.disableSubMenuLink,u.slideSpeed=u.options.slideSpeed,e("html").removeClass("nav-no-js"),u.collapseSubMenus(u),u.bindEvents(u)},bindEvents:function(i){i.$menuButton.on("click",function(e){i.toggleNav(i),e.preventDefault()}),i.$nav.on("click",i.subMenu+" > a",function(n){var u=e(this);i.isSubMenuLinkDisabled(i,u)&&(i.toggleSubMenu(i,u.parent()),n.preventDefault())}),1==i.mouseOver&&(i.$nav.on("mouseenter",i.subMenu,function(){0==i.mobileMode&&i.openSubMenu(i,e(this))}),i.$nav.on("mouseleave",i.subMenu,function(){0==i.mobileMode&&i.closeSubMenu(i,e(this))})),e(n).on("resize",function(){i.resetNav(i)})},isSubMenuLinkDisabled:function(e,n){return"always"==e.disableSubMenuLink||"#"==n.attr("href")||"mobile"==e.disableSubMenuLink&&1==e.mobileMode||"desktop"==e.disableSubMenuLink&&0==e.mobileMode},toggleNav:function(n){n.$nav.stop().clearQueue().slideToggle(n.slideSpeed,function(){var i=e(this);i.is(":hidden")?(n.collapseSubMenus(n),e(this).attr("style","display: none;")):e(this).attr("style","display: block;")}),n.$body.toggleClass("nav-lock-scroll")},toggleSubMenu:function(e,n){n.hasClass("nav-active")?e.closeSubMenu(e,n):e.openSubMenu(e,n)},openSubMenu:function(n,i){i.addClass("nav-active").children("ul").stop().clearQueue().slideDown(n.slideSpeed,function(){e(this).attr("style","display: block;")}),i.siblings(n.subMenu).removeClass("nav-active").children("ul").slideUp(n.slideSpeed,function(){e(this).clearQueue()}).find(".nav-active").removeClass("nav-active").children("ul").slideUp(n.slideSpeed,function(){e(this).clearQueue()})},closeSubMenu:function(n,i){i.removeClass("nav-active").children("ul").stop().clearQueue().slideUp(n.slideSpeed,function(){e(this).attr("style","display: none;")}).find(".nav-active").removeClass("nav-active").children("ul").slideUp(n.slideSpeed,function(){e(this).clearQueue()})},resetNav:function(e){var n=e.isCurrentlyMobile(e);e.mobileMode!==n&&(e.$nav.removeAttr("style").find("ul").removeAttr("style"),e.$body.removeClass("nav-lock-scroll"),e.collapseSubMenus(e),e.mobileMode=n)},collapseSubMenus:function(e){e.$subMenu.removeClass("nav-active").children("ul").hide()},isCurrentlyMobile:function(e){return e.$menuButton.is(":visible")}};e.fn.nav=function(e){return this.each(function(){var n=Object.create(i);n.init(e,this)})},e.fn.nav.options={navButton:".nav-button",subMenu:".page_item_has_children",mouseOver:!0,disableSubMenuLink:"always",slideSpeed:300}}(jQuery,window,document),"function"!=typeof Object.create&&(Object.create=function(e){function n(){}return n.prototype=e,new n});


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

  // Submenu
  $('.header-menu').nav();

  // Ajusta a abertura do submenu de navegação.
  adjustOpeningSubmenu = () => {
    let navMenu = '.header-menu';

    // Add arrow element to the parent li items and chide its child uls
    $(navMenu).find('li ul').each(function () {
      var sub_ul = $(this),
        parent_a = sub_ul.prev('a'),
        parent_li = parent_a.parent('li').first();

      if (parent_li.hasClass('page_item_has_children')) {
        let ahref = parent_a.attr('href'),
          aTitle = parent_a.text();

        parent_a.append('<i class="fas fa-sort-down ml-2"></i>');
        // Adiciona uma nova li com o link do item pai
        parent_a.next('.children').append('<li><a href="' + ahref + '"><span>' + aTitle + '</span></a></li>');
        // Remove o href para poder abrir o submenu
        parent_a.attr('href', 'javascript:void(0)');
      }
    });
  }

  fixedMenu();
  adjustOpeningSubmenu();
});
