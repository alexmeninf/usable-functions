<header class="info-menu-top fixed-header">
  <div class="container-xxl px-3">
    <div class="d-flex align-items-center justify-content-between">
      <div class="menu-brand text-center text-xl-start me-4">
        <a href="<?= get_home_url() ?>" class="d-inline-block">
          <?php apply_filters('logo_tema', null); ?>
        </a>
      </div>

      <button type="button" class="btn-circle drawerButton d-xl-none" data-drawer-id="drawer" aria-label="Navigation button"><i class="fal fa-bars"></i></button>

      <div class="d-none d-xl-flex align-items-center">
        <div class="position-relative me-4">
          <?php get_search_form(['form_class' => 'visibility-search']) ?>

          <nav class="nav-list-desktop">
            <ul class="header-menu menu-main list-inline">
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
          </nav>
        </div>

        <div class="position-relative">
          <ul class="list-inline shop-actions">
            <li>
              <button type="button" class="cta-search"><i class="fa-light fa-magnifying-glass"></i></button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="sticky-menu-top d-xl-none">
  <div class="wrapper-form">
    <?php get_search_form(); ?>
    <button type="button" class="searchfield_cancel">cancelar</button>
  </div>
</div>
