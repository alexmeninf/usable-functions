<?php

if ( WP_REMOVE_SUPPORT_COMMENTS !== false ) {
  // Removes from admin menu
  add_action( 'admin_menu', 'my_remove_admin_menus' );
  function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
  }

  // Removes from post and pages
  add_action('init', 'remove_comment_support', 100);

  function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
  }

  // Removes from admin bar
  function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
  }
  add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
}
