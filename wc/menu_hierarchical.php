<?php 

/**
 * Recursively get taxonomy and its children
 *
 * @param string $taxonomy
 * @param int $parent - parent term id
 * @return array
 */
function get_taxonomy_hierarchy( $taxonomy, $parent = 0 ) {
	// only 1 taxonomy
	$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
	// get all direct descendants of the $parent
  $terms = get_terms( $taxonomy, array('hide_empty' => false,  'parent' => $parent ));
	// prepare a new array.  these are the children of $parent
	// we'll ultimately copy all the $terms into this new array, but only after they
	// find their own children
	$children = array();
	// go through all the direct descendants of $parent, and gather their children
	foreach ( $terms as $term ){
		// recurse to get the direct descendants of "this" term
		$term->children = get_taxonomy_hierarchy( $taxonomy, $term->term_id );
		// add the term to our new array
		$children[ $term->term_id ] = $term;
	}
	// send the results back to the caller
	return $children;
}

/**
 * Recursively get all taxonomies as complete hierarchies
 *
 * @param $taxonomies array of taxonomy slugs
 * @param $parent int - Starting parent term id
 *
 * @return array
 */
function get_taxonomy_hierarchy_multiple( $taxonomies, $parent = 0 ) {
	if ( ! is_array( $taxonomies )  ) {
		$taxonomies = array( $taxonomies );
	}

	$results = array();
	foreach( $taxonomies as $taxonomy ){
		$terms = get_taxonomy_hierarchy( $taxonomy, $parent );

		if ( $terms ) {
			$results[ $taxonomy ] = $terms;
		}
	}
	return $results;
}

/*
 * Exibe um menu baseado na hieraquia de niveis das categorias.
 */
function menu_hierarchical( $taxonomies ) {
  $list_terms = get_taxonomy_hierarchy( $taxonomies );
  $html = '<ul>';

  foreach ($list_terms as $term) {
    if ( $term->parent == 0 ) {
      $html .= '<li>' .$term->name;

      if (!empty($term->children)) {
       $html .= get_parents_terms($term->children);
       $html .= '</li>' . PHP_EOL;
      } else {
        $html .= '</li>' . PHP_EOL;
      }
    }
  }

  $html .= '</ul> <--- /Main ul --->';

  echo $html;
}

/**
 * Função recursiva, verifica todos os subniveis das categorias
 */
function get_parents_terms($terms) {
  $html = '';
  $html = '<ul class="submenu">';

  foreach ($terms as $term) {
    $html .= '<li>' .$term->name;

    if (!empty($term->children)) {
      $html .= get_parents_terms($term->children);
      $html .= '</li>';
    } else {
      $html .= '</li>';
    }
  }
  $html .= "</ul>";

  return $html;
}
