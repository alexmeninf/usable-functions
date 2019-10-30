<?php 
//================================================
/*                                              *
 *Set WooCommerce image dimensions upon theme activation*
 *                                              */
//================================================
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
    unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
    return $enqueue_styles;
}
// Or just remove them all in one line
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


//================================================
/*                                              *
 *          Enqueue your own stylesheet         *
 *                                              */
//================================================
function wp_enqueue_woocommerce_style(){
    wp_register_style( 'layout-woocommerce', THEMEROOT . '/woocommerce/assets/css/woocommerce-layout.css' );
    wp_register_style( 'smallscreen-woocommerce', THEMEROOT . '/woocommerce/assets/css/woocommerce-smallscreen.css' );
    wp_register_style( 'mytheme-woocommerce', THEMEROOT . '/woocommerce/assets/css/woocommerce.css' );
    
    if ( class_exists( 'woocommerce' ) ) {
        wp_enqueue_style( 'smallscreen-woocommerce' );
        wp_enqueue_style( 'layout-woocommerce' );
        wp_enqueue_style( 'mytheme-woocommerce' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style', 0 );
