<?php

/**
 * activate_layout
 * Exibe o layout da CPL
 *
 * @return void
 */
function activate_layout() {
  if (get_field('ativar_cpl')) {
    get_template_part('template-parts/pages/cpl/cpl-default');
  }
}

/**
 * the_support_material
 * Mostra o botão do material de apoio.
 *
 * @param  mixed $link
 * @param  mixed $date
 * @return void
 */
function the_support_material() {
  $link   = get_field("link_atividade");
  $date   = get_field('publication_data');

  if ( $link ) : 
    $link_url = $link['url'];
    $link_title = $link['title'] ? $link['title'] : 'Material de apoio';
    $link_target = $link['target'] ? $link['target'] : '_blank'; 
    
    if (is_published($date)) : ?>

      <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>

  <?php endif;
  endif;
}


/**
 * the_sales_button
 * Mostra o botão de vendas
 *
 * @return void
 */
function the_sales_button() {
  $link_sales     = get_field('link_hotmart', 'options');
  $button         = '<a href="'. $link_sales .'" target="_blank" rel="noopener">Matricule-se agora!</a>';
  $date           = get_field('automatically_publish', 'options');
  $specific_pages = get_field('show_on_specific_pages', 'options');

  if (get_field('show_btn_vendas', 'options') && $link_sales != '' && is_page($specific_pages)) : 
    if ($date) :
      if (is_published($date)) :
        echo $button;
      endif;
    else : 
      echo $button;
    endif;
  endif;
}
