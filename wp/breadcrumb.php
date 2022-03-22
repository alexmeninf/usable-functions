<?php 
/**
 * custom_breadcrumbs
 */
function custom_breadcrumbs($breadcrums_class = 'breadcrumb mb-0') {
  // Configuracoes
  $separator          = '';
  $breadcrums_id      = 'breadcrumbs';
  $li_class           = 'breadcrumb-item';
  $home_title         = '<i class="fas fa-home-lg-alt"></i> <span class="visually-hidden">'.__('Início', 'startertheme').'</span>';

  // Se você tiver algum tipo de postagem personalizado com taxonomias personalizadas, coloque o nome da taxonomia abaixo (e.g. product_cat)
  $custom_taxonomy    = 'product_cat';

  // Obter as informações de consulta e publicação
  global $post, $wp_query;

  // Não exibir na página inicial
  if (!is_front_page()) {

    // Construa o breadcrumbs
    echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

    // Home page
    echo '<li class="'.$li_class.' item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="'.__('Início', 'startertheme').'">' . $home_title . '</a></li>';

    if ( ! empty($separator) ) 
      echo '<li class="'.$li_class.' separator"> ' . $separator . ' </li>';

    if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

      $archive_title = '';
      if (is_day()) {
        $format_date = (get_bloginfo('lang') == 'pt-BR') ? get_the_time('j/m/Y') : get_the_time('F j, Y');
        $archive_title = __('Registros de ', 'startertheme') . $format_date;
    
      } elseif (is_month()) {
        $archive_title = __('Registros de ', 'startertheme') . get_the_time('F, Y');
    
      } elseif (is_year()) {
        $archive_title = __('Registros de ', 'startertheme') . get_the_time('Y');
      }    
      
      echo '<li class="'.$li_class.' item-current item-archive"><span class="bread-current bread-archive">' . $archive_title . '</span></li>';

    } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

      // Se post é um tipo de postagem personalizado
      $post_type = get_post_type();

      // Se for um nome e link de exibição de tipo de postagem personalizado
      if ($post_type != 'post') {

        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="'.$li_class.' item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
        
        if ( ! empty($separator) ) 
          echo '<li class="'.$li_class.' separator"> ' . $separator . ' </li>';
      }

      $custom_tax_name = get_queried_object()->name;
      echo '<li class="'.$li_class.' item-current item-archive"><span class="bread-current bread-archive">' . $custom_tax_name . '</span></li>';

    } else if (is_single()) {

      $post_type = get_post_type();

      if ($post_type != 'post') {
        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="'.$li_class.' item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
        
        if ( ! empty($separator) ) 
          echo '<li class="'.$li_class.' separator"> ' . $separator . ' </li>';
      }

      // Obter informações de categoria
      $category = get_the_category();

      if (!empty($category)) {
        // A última publicação da categoria está em
        $last_category = end($category);

        // Obter pai de qualquer categoria
        $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
        $cat_parents = explode(',', $get_cat_parents);

        // Loop através de categorias pai e armazenar em variável $ cat_display
        $cat_display = '';
        foreach ($cat_parents as $parents) {
          $cat_display .= '<li class="item-cat">' . $parents . '</li>';
        }
      }

      // Se for um tipo de publicação personalizado dentro de uma taxonomia personalizada
      $taxonomy_exists = taxonomy_exists($custom_taxonomy);
      
      if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
        $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
        $cat_id         = $taxonomy_terms[0]->term_id;
        $cat_nicename   = $taxonomy_terms[0]->slug;
        $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
        $cat_name       = $taxonomy_terms[0]->name;
      }

      // Verifique se o post está em uma categoria
      if (!empty($last_category)) {
        echo $cat_display;
        echo '<li class="'.$li_class.' item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

        // Em caso de publicação em uma taxonomia personalizada
      } else if (!empty($cat_id)) {
        echo '<li class="'.$li_class.' item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
        
        if ( ! empty($separator) ) 
          echo '<li class="'.$li_class.' separator"> ' . $separator . ' </li>';
        
        echo '<li class="'.$li_class.' item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
      
      } else {
        echo '<li class="'.$li_class.' item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
      
      }
    } else if (is_category()) {
      // Página Category
      echo '<li class="'.$li_class.' item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></li>';
    
    } else if (is_page()) {
      // Página padrão
      if ($post->post_parent) {

        $anc = get_post_ancestors($post->ID);
        $anc = array_reverse($anc);

        if (!isset($parents)) $parents = null;
        foreach ($anc as $ancestor) {
          $parents .= '<li class="'.$li_class.' item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
          
          if ( ! empty($separator) ) 
            $parents .= '<li class="'.$li_class.' separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
        }

        echo $parents;

        // Página Atual
        echo '<li class="'.$li_class.' item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
      
      } else {
        // Basta exibir a página atual se não os pais
        echo '<li class="'.$li_class.' item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';
      }

    } else if (is_tag()) {

      // Página de Tag
      // Obter informações de tag
      $term_id        = get_query_var('tag_id');
      $taxonomy       = 'post_tag';
      $args           = 'include=' . $term_id;
      $terms          = get_terms($taxonomy, $args);
      $get_term_id    = $terms[0]->term_id;
      $get_term_slug  = $terms[0]->slug;
      $get_term_name  = $terms[0]->name;

      // Exibir o nome da Tag
      echo '<li class="'.$li_class.' item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></li>';
    
    } elseif (is_day()) {

      // Day archive
      // Year link
      echo '<li class="'.$li_class.' item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
      
      if ( ! empty($separator) ) 
        echo '<li class="'.$li_class.' separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';


      // Month link
      echo '<li class="'.$li_class.' item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
      
      if ( ! empty($separator) ) 
        echo '<li class="'.$li_class.' separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';


      // Day display
      echo '<li class="'.$li_class.' item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</span></li>';
    
    } else if (is_month()) {
      // Arquivo               

      echo '<li class="'.$li_class.' item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
      
      if ( ! empty($separator) ) 
        echo '<li class="'.$li_class.' separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

      echo '<li class="'.$li_class.' item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</span></li>';
    
    } else if (is_year()) {
      echo '<li class="'.$li_class.' item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</span></li>';
    
    } else if (is_author()) {
      // Autor
      // Get the author information
      global $author;
      $userdata = get_userdata($author);

      echo '<li class="'.$li_class.' item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</span></li>';
    
    } else if (get_query_var('paged')) {
      echo '<li class="'.$li_class.' item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="' . __('Página', 'startertheme') . ' ' . get_query_var('paged') . '">' . __('Página', 'startertheme') . ' ' . get_query_var('paged') . '</span></li>';
    
    } else if (is_search()) {
      // Página Search
      echo '<li class="'.$li_class.' item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="'.__('Resultado da pesquisa por', 'startertheme').': ' . get_search_query() . '">'.__('Resultado da pesquisa por', 'startertheme').': ' . get_search_query() . '</span></li>';
    
    } elseif (is_404()) {
      // Pagina 404
      echo '<li class="'.$li_class.'">' . __('Página não encontrada', 'startertheme') . '</li>';
    }

    echo '</ul>';
  }
}
