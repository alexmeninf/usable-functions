<?php
/**
 * Logo do site
 * 
 * @return mixed
 */
function callback_custom_logo_setup() {
  $defaults = array(
    'height'               => 60,
    'width'                => 'auto',
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => array('site-title', 'site-description'),
    'unlink-homepage-logo' => true,
  );

  add_theme_support('custom-logo', $defaults);
}

add_action('after_setup_theme', 'callback_custom_logo_setup');

function theme_logo_callback() {
  $custom_logo_id = get_theme_mod( 'custom_logo' );
  $logo           = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    
  if ( has_custom_logo() ) {
    echo '<img src="' . esc_url( $logo[0] ) . '" alt="Logo ' . get_bloginfo( 'name' ) . '">'; 
  }
}

add_filter('logo_tema', 'theme_logo_callback', 10);


// Para aplicar so usar o filtro abaixo
// apply_filters('logo_tema', null)
