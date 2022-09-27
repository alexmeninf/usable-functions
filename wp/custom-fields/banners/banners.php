<section class="section-banner">
    <div class="owl-carousel owl-theme" data-dots="false" data-nav="true" data-margin="8">
      <?php
      $query = new WP_Query(array('post_type' => 'banner', 'posts_per_page' => -1, 'orderby' => 'date'));
      if ($query->have_posts('banners')) :
        while ($query->have_posts('banners')) :
          $query->the_post(); ?>

          <div>
            <?php
            $link = get_field("link_banner");

            if ($link) :
              $link_url    = $link['url'];
              $link_title  = $link['title'] ? $link['title'] : 'Veja mais';
              $link_target = $link['target'] ? $link['target'] : '_parent';

              echo '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" title="' . esc_html($link_title) . '">';
            endif;
            ?>

            <img src="<?php the_field('banner_desktop') ?>" alt="Banner" class="lazyload img-fluid d-none d-lg-block">
            <img src="<?php the_field('banner_tablet') ?>" alt="Banner" class="lazyload img-fluid d-none d-md-block d-lg-none">
            <img src="<?php the_field('banner_mobile') ?>" alt="Banner" class="lazyload img-fluid d-md-none">

            <?php
            if ($link) echo '</a>';
            ?>
          </div>

      <?php endwhile;
      endif;
      wp_reset_query(); ?>
    </div>
</section>
