<?php
# ==================================
# =           Taxonomia            =
# ==================================
function NAME_HERE_init() {
  // create a new taxonomy
  register_taxonomy(
    'NAME_HERE', //Name of the taxonomy
    'NAME_POST_TYPE', //Name of post type
    array(
      'label'        => __( 'NAME_HEREs' ),
      'rewrite'      => array( 'slug' => 'NAME_HERE' ),
      'hierarchical' => true,
    )
  );
}
add_action( 'init', 'NAME_HERE_init' );


/*====================================/
=            ADD NEW COLUMN           =
======================================= */
function NAME_HERE_head($defaults) {
  $defaults['NAME_HERE'] = 'NAME_HERE';
  return $defaults;
}

// COLUMN CONTENT
function NAME_HERE_content($column_name, $post_ID) {
  if( $column_name == 'NAME_HERE' ){
    $terms = wp_get_post_terms($post_ID, 'NAME_HERE');
    foreach($terms as $term) :
      echo '<a href="'.get_admin_url().'edit.php?NAME_HERE='.$term->slug.'&post_type=NAME_POST_TYPE">'.$term->name.'</a>';
      echo next($terms) ? ', ' : '';
    endforeach;
  }
}

add_filter('manage_NAME_POST_TYPE_posts_columns', 'NAME_HERE_head');
add_action('manage_NAME_POST_TYPE_posts_custom_column', 'NAME_HERE_content', 5, 2);

// Altera ordem dos itens
add_filter('manage_posts_columns', 'column_order');
function column_order($columns) {
  $n_columns = array();
  $move = 'NAME_HERE'; // what to move
  $before = 'date'; // move before this
  foreach($columns as $key => $value) {
    if ($key==$before){
      $n_columns[$move] = $move;
    }
    $n_columns[$key] = $value;
  }
  return $n_columns;
}