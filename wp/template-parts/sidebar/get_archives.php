<?php 
/**
 * Documentation URl: https://developer.wordpress.org/reference/functions/wp_get_archives/
 */

$args = array(
    'type'            => 'monthly',
    'limit'           => '',
    'format'          => 'html', 
    'before'          => '',
    'after'           => '',
    'show_post_count' => false,
    'echo'            => 1,
    'order'           => 'DESC'
);
wp_get_archives( $args );
?>