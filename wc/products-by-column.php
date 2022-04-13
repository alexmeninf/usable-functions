<?php

/**
 * query_products_loop_horizontal
 * Ordene os produtos por colunas, sendo possivel criar slides tambem.
 *
 * @param  mixed $title           - Título da sessão
 * @param  mixed $icon_uri        - Icone ao lado do título
 * @param  mixed $args            - Argumentos para o get_posts()
 * @param  mixed $items_per_slide - Quantidade de produtos por slide.
 * @return void
 */
function query_products_loop_horizontal($title, $icon_uri = '', $args = array(), $items_per_slide = 3) {

  if (!empty($icon_uri)) {
    $icon_uri = '<img class="icon-title" src="'. $icon_uri .'" alt="icon" loading="lazy"> ';
  }

  if (empty($args)) {
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => 9,
      'order'          => 'desc',
      'orderby'        => 'name',
      'post_status'    => 'publish',
    );
  }

  if (class_exists('WooCommerce')) :

    $loop        = get_posts($args);
    $total       = count($loop);
    $pages_count = ceil($total / $items_per_slide);

    if ($loop) : ?>
        
        <?php
        for ($i = 0; $i < $pages_count; $i++) : ?>
          <div class="col-12 col-lg-6 col-xl-4">
            <?php
            foreach ($loop as $key => $p) :                
              setup_postdata($p);

              if ($key > ($items_per_slide - 1)) :
                $loop = array_slice($loop, $items_per_slide);
                break;
              else :
                get_template_part('template-parts/content-product-horizontal');
                continue;
              endif;

            endforeach;

            wp_reset_postdata();
            ?>          
          </div><!-- End cols -->
  
        <?php endfor; ?>
    <?php endif; 
  endif;
}
