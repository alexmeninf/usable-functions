<?php 

if ( ! defined( 'ABSPATH' ) ) 
	exit;

  
date_default_timezone_set('UTC');

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
    $link_url    = $link['url'];
    $link_title  = $link['title'] ? $link['title'] : __('Material de apoio', 'bluelizard');
    $link_target = $link['target'] ? $link['target'] : '_self'; 
    
    if ( is_published($date) ) : 
      if ( get_field('enable_download') ) : ?>
        <a class="btn-theme btn-material" href="<?php echo get_bloginfo('url') . '/download.php?file=' . esc_url( $link_url ); ?>"><?php echo esc_html( $link_title ); ?></a>
      <?php else: ?>
        <a class="btn-theme btn-material" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
      <?php endif;
    else: ?>
      <a class="btn-theme btn-material" href="javascript:void(0);"><?php echo is_today_published_text($date) ?></a>
    <?php endif;
  endif;
}

/**
 * the_sales_button
 * Mostra o botão de vendas
 *
 * @return void
 */
function the_sales_button( $btnText = 'Quero me matricular agora!', $class = '' ) {
  $link_sales     = get_field('link_hotmart', 'options');
  $button         = '<a href="'. $link_sales .'" target="_blank" class="btn-theme btn-sales-hotmart '.$class.'" rel="noopener noreferrer">'. $btnText .'</a>';
  $date           = get_field('automatically_publish', 'options');
  $specific_pages = get_field('show_on_specific_pages', 'options');

  if ( get_field('show_btn_vendas', 'options') && $link_sales != '' && is_page($specific_pages) ) : 
    if ( $date ) :
      if ( is_published($date) ) :
        echo $button;
      endif;
    else : 
      echo $button;
    endif;
  endif;
}

/**
 * the_embed_video
 *
 * @param  mixed $embed - Get the full iframe
 * @param  mixed $date_published - Given in which the video will appear
 * @param  mixed $img - Thumbnail for video
 * @return string
 */
function the_embed_video($iframe, $date_published, $img) {
  $html_embed = '<div class="embed-video ratio ratio-16x9">';
  $html_embed .= embed_video($iframe);
  $html_embed .= '</div>';

  $html_img = '<img src="'. $img['url'] .'" alt="'. __('Em breve', 'bluelizard') .'" class="img-fluid img_coming_soon">';

  // Libera o vídeo meia noite, caso for uma live.
  if (get_field('enable_earlier')) {
    $data_event_with_year = date('Y-m-d', strtotime(str_replace('-', '/', $date_published)));
    $enable_earlier = (strtotime(date('Y-m-d H:i:s') . '-3 hours') >= strtotime($data_event_with_year . ' 00:00:00')) ? true : false;
  }

  if ( is_published($date_published) || $enable_earlier ) {
    echo $html_embed;
  } else {
    echo $html_img;
  }
}


/**
 * embed_video
 * 
 * @param  mixed $iframe
 * @return string returns an iframe
 */
function embed_video($iframe) {
  preg_match('/src="(.+?)"/', $iframe, $matches);
  $src = $matches[1];

  $params = array(
    'controls'  => 1,
    'rel'       => 0,
  );
  $new_src = add_query_arg($params, $src);
  $iframe  = str_replace($src, $new_src, $iframe);

  // Add extra attributes to iframe HTML.
  $attributes = 'frameborder="0"';
  $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
  
  return $iframe;
}


/**
 * embed_live_chat_youtube
 * Mostra o chat do vídeo ao vivo
 *
 * @param  mixed $iframe
 * @return void
 */
function embed_live_chat_youtube($iframe) {
  preg_match('/src="(.+?)"/', $iframe, $matches);
  $url = $matches[1];

  if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match_id)) {
    $html_embed = '<div class="embed-video ratio ratio-1x1">';
    $html_embed .= '<iframe width="1280" height="720" src="https://www.youtube.com/live_chat?v='.$match_id[1].'&embed_domain='.$_SERVER['SERVER_NAME'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    $html_embed .= '</div>';
  } else {
    $html_embed = '<p class="op-4 fs-6 py-5"><i class="fad fa-info-circle"></i> O chat estará disponível somente na hora da live...</p>';
  }

  echo $html_embed;
}


/**
 * is_published
 *
 * @param  mixed $date
 * @return boolean
 */
function is_published($date) {  
  $check = false;

  if ( strtotime(date('Y-m-d H:i:s') . '-3 hours') >= strtotime($date) ) {
    $check = true;
  }

   return $check;
}


/**
 * is_today_published_text
 *
 * @param  mixed $date
 * @return string
 */
function is_today_published_text($date) {
  $data_event_with_year = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
  $data_event           = date('d-m', strtotime(str_replace('-', '/', $date)));
  $hour_event           = date('H:i', strtotime($date));

  if ( strtotime(date('Y-m-d H:i:s') . '-3 hours') >= strtotime($data_event_with_year . ' 00:00:00') ) {
    return '<i class="far fa-lock-alt"></i> Hoje às ' . $hour_event . 'h';
  } else {
    return '<i class="far fa-lock-alt"></i> Disponível dia ' . str_replace('-', '/', $data_event) . ' (às '. $hour_event .')';
  }
}
