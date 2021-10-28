<?php
function the_title_page() {
  $lang = get_bloginfo("language");

  if (is_404()) {
    echo __('Página não encontrada', 'menin');

  } elseif (is_tag()) {
    single_tag_title();

  } elseif (is_category()) {
    single_cat_title();
    
  } elseif (is_tax()) {
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    echo $term->name;

  } elseif (is_day()) {
    $date = ($lang == 'pt-BR') ? get_the_time('j \d\e F \d\e Y') : get_the_time('F j, Y');
    echo __('Registros de ', 'menin') . $date;

  } elseif (is_month()) {
    $date = ($lang == 'pt-BR') ? get_the_time('F \d\e Y') : get_the_time('F, Y');
    echo __('Registros de ', 'menin') . $date;

  } elseif (is_year()) {
    echo __('Registros de ', 'menin') . get_the_time('Y');

  } elseif (is_author()) {
    echo __('Registros do autor', 'menin');

  } elseif (isset($_GET['p']) && !empty($_GET['p'])) {
    echo __('Registros do blog', 'menin');

  } elseif (is_search()) {
    echo __('Resultados da pesquisa', 'menin');

  } else {
    if (class_exists('WooCommerce')) {
      if (is_shop()) {
        echo __('Os melhores produtos para você', 'menin');
      } else {
        the_title();
      }
    } else {
      echo wp_trim_words(get_the_title(), 6, '...');
    }
  }
}
