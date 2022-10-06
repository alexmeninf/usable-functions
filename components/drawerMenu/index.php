<nav class="drawer-mobile" id="drawer">
  <span class="close-menu" aria-label="Fechar">
    <i class="fal fa-times"></i>
  </span>
  <div class="wrap backdrop-filter">
    <div class="wrapper-form">
      <?php get_search_form(); ?>
      <a class="searchfield_cancel">cancelar</a>
    </div>

    <div class="img-brand">
      <a href="<?php echo get_home_url() ?>" title="<?php bloginfo('name') ?>">
        <?php apply_filters('logo_tema', null) ?>
      </a>
    </div>

    <?php
    wp_nav_menu(
      array(
        'theme_location'  => 'primary',
        'container'       => 'div',
        'container_class' => '',
        'menu_class'      => 'header-menu'
      )
    ); ?>

  </div>
</nav>

<aside class="drawer-wrapper drawer" id="drawer">
  <span class="close-menu btn-circle" aria-label="Fechar">
    <i class="fal fa-times"></i>
  </span>

  <div class="wrapper">
    
    <div class="wrapper-form">
      <?php get_search_form(); ?>
      <a class="searchfield_cancel">cancelar</a>
    </div>

    <div class="menu-brand text-center">
      <a href="<?= get_home_url() ?>" class="d-inline-block">
        <?php apply_filters('logo_tema', null); ?>
      </a>
    </div>

    <ul class="sidebar-links menu-main list-inline">
      <li><a href="#">Item</a></li>
      <li class="menu-item-has-children">
        <a data-clone="true" data-text="Painel" href="#">Minha conta</a>
        <ul class="sub-menu">
          <li>
            <a href="#">
              Pedidos
            </a>
          </li>
        </ul>
      </li>
    </ul>
    

    <div class="sidebar-footer">
      <button type="button" class="link-sidebar">
        <span class="clamp-1">Link Footer</span>
      </button>
    </div>
  </div>
</aside>
