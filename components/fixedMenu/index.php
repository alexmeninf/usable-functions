<header class="fixed-header expand-xl">
  <div class="wrap">
    <div class="img-brand">
      <a href="<?php echo get_home_url() ?>" title="<?php bloginfo('name') ?>">
        <?php apply_filters('logo_tema', null) ?>
      </a>
    </div>

    <div class="d-flex justify-content-between align-items-center">
      <button type="button" class="btn-menu drawerButton" data-drawer-id="drawer" aria-label="Navigation button"><i class="far fa-bars"></i></button>

      <?php
      wp_nav_menu(
        array(
          'theme_location'  => 'primary',
          'container'       => 'nav',
          'container_class' => 'nav-list',
          'menu_class'      => 'header-menu'
        )
      ); ?>

      <?php get_search_form(); ?>
    </div>
  </div>
</header>
