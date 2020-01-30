<?php 
/**
 * Set WooCommerce image dimensions upon theme activation
 */
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
  unset( $enqueue_styles['woocommerce-general'] );	
  unset( $enqueue_styles['woocommerce-layout'] );	
  unset( $enqueue_styles['woocommerce-smallscreen'] );

  return $enqueue_styles;
}
// Or just remove them all in one line
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


/**
 * Enqueue your own stylesheet
 */
function wp_enqueue_woocommerce_style(){
  wp_register_style( 'mytheme-woocommerce', THEMEROOT . '/woocommerce/assets/css/woocommerce.css' );
  
  if ( class_exists( 'woocommerce' ) ) {
    wp_enqueue_style( 'mytheme-woocommerce' );
  }
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style', 0 );


/**
 * remove some styles
 */
function wc_remove_block_library_css(){
	if (!is_admin()) {
		wp_dequeue_style( 'wc-block-style' );
		wp_dequeue_style( 'wp-block-library' );
	}
} 
add_action( 'wp_enqueue_scripts', 'wc_remove_block_library_css' );