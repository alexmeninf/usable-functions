<?php
/*----------  PAGINATION  ----------*/
$posts_total    = new WP_Query(array('post_type' => 'post', 'posts_per_page' => -1));
$posts_count    = $posts_total->post_count;//total de posts
$posts_per_page = 6;
$pages_count    = ceil($posts_count / $posts_per_page);
$current_page   = ( isset($_GET['pg']) && $_GET['pg'] > 1 && $_GET['pg'] <= $pages_count ) ? $_GET['pg'] : 1;
/*----------  Loop  ----------*/
$sql_posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $posts_per_page, 'order' => 'DESC', 'paged' => $current_page));
if( $sql_posts->have_posts() ): while( $sql_posts->have_posts() ): $sql_posts->the_post(); ?>


<?php endwhile; endif; ?>


<?php
/**
 * Páginação
 * 
 * @version 1.1
 *
 * @param  integer $current_page
 * @param  integer $pages_count
 * @param  integer $maxLinks
 * 
 * @return mixed
 */
function get_pagination($current_page, $pages_count, $maxLinks = 2) {
  wp_reset_query();

  $args = "?";
  $firstRun = true;

  if (class_exists('WooCommerce')) :
    foreach ($_GET as $key => $val) {
      // Remove duplicate 'pg' parameter
      $check_pg = ('pg' != $key);

      if ($key != $parameter) {
        if (!$firstRun && $check_pg) {
          $args .= "&";
        } else {
          $firstRun = false;
        }

        if ($check_pg) {
          $args .= $key . "=" . $val;
        }
      }
    }
  endif;

  if (is_search()) {
    $args .= 's=' . get_search_query();
    $url = get_bloginfo('url');

  } elseif (is_category()) {
    $url = get_category_link(get_queried_object()->term_id);

  } elseif (is_tax()) {
    $url = get_term_link(get_queried_object()->term_id);

  } elseif (is_tag()) {
    $url = get_tag_link(get_queried_object()->term_id);

  } elseif (is_day()) {
    $url = get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'));

  } elseif (is_month()) {
    $url = get_month_link(get_the_time('Y'), get_the_time('m'));

  } elseif (is_year()) {
    $url = get_year_link(get_the_time('Y'));

  } elseif (is_author()) {
    $author_id = get_the_author_meta( 'ID' );
    $url    = get_author_posts_url( $author_id );

  } else {
    $url  = get_the_permalink(get_the_ID());
  }

  $url = esc_url($url) . $args;

  if ($pages_count > 0) : ?>

    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <?php
        // Check if the first page 
        $disable_link = ($current_page == 1) ? 'disabled' : '';

        echo '<li class="page-item">';
        echo '<a class="page-link" aria-label="Previous" title="' . __('Página anterior', 'iff') . '" ' . $disable_link . ' href="' . $url . '&pg=1"><span>&laquo;</span></a>';
        echo '</li>';

        // Previous pages
        for ($i = $current_page - $maxLinks; $i <= $current_page - 1; $i++) :
          if ($i >= 1) :
            echo '<li>';
            echo '<a class="page-link" href="' . $url . '&pg=' . $i . '">' . $i . '</a>';
            echo '</li>';
          endif;
        endfor;

        // Current page
        echo '<li class="page-item active"><a class="page-link" href="' . $url . '&pg=' . $current_page . '"> ' . $current_page . '</a></li>';

        // Next pages        
        $displaying_the_last = false;

        for ($i = $current_page + 1; $i <= $current_page + $maxLinks; $i++) :
          if ($i <= $pages_count) :
            echo '<li class="page-item">';
            echo '<a class="page-link" href="' . $url . '&pg=' . $i . '">' . $i . '</a>';
            echo '</li>';
          endif;

          // check if the last page is shown
          if ($i == $pages_count - 1 || $i == $pages_count) $displaying_the_last = true;
        endfor;

        // Show the last page
        if ($current_page != $pages_count && !$displaying_the_last) :
          echo '<li class="page-item"><a class="page-link" disabled>...</a></li>';
          echo '<li class="page-item">';
          echo '<a class="page-link" href="' . $url . '&pg=' . $pages_count . '">' . $pages_count . '</a>';
          echo '</li>';
        endif;

        // Check if the last page 
        $disable_link = ($current_page == $pages_count) ? 'disabled' : 'title="' . __('Próxima página', 'iff') . '"';

        echo '<li class="page-item">';
        echo '<a class="page-link" aria-label="Next" ' . $disable_link . ' href="' . (($current_page != $pages_count) ? ($url . '&pg=' . ($current_page + 1)) : '') . '"><span>&raquo;</span></a>';
        echo '</li>';
        ?>
      </ul>
    </nav>
  <?php endif;
}

