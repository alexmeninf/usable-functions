<?php
/**
 * the_embed_video
 *
 * @param  mixed $embed - Get the full iframe
 * @param  mixed $date_published - Given in which the video will appear
 * @param  mixed $img - Thumbnail for video
 * @return string
 */
function the_embed_video($iframe, $date_published, $img) {
  $html_embed = '<div class="embed-video">';
  $html_embed .= embed_video($iframe);
  $html_embed .= '</div>';

  $html_img = '<img src="'. $img['url'] .'" alt="Em breve" class="img-fluid img_coming_soon">';

  if ( is_published($date_published) ) {
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
    'controls'  => 0,
    'hd'        => 1,
    'autohide'  => 1
  );
  $new_src = add_query_arg($params, $src);
  $iframe  = str_replace($src, $new_src, $iframe);

  // Add extra attributes to iframe HTML.
  $attributes = 'frameborder="0"';
  $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
  
  return $iframe;
}


/**
 * is_published
 *
 * @param  mixed $date
 * @return boolean
 */
function is_published($date) {
	date_default_timezone_set('America/Sao_Paulo');
	$check = false;

	if ( strtotime(date('d-m-Y H:i:s')) >= strtotime($date) ) {
	 $check = true;
	}

	return $check;
}
