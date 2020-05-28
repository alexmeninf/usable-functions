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
// functions.php

/**
 * $current_page - Página atual
 * $pages_count - total de páginas de posts
 * $maxLinks - tamanho da paginação (A esqueda e a direita)
 */
function get_pagination($current_page, $pages_count, $maxLinks = 2) {
	wp_reset_query();
	$args = '';

	if (is_search()) {
		$args .= 's=' . get_search_query() . '&';
		$url = get_bloginfo('url');

	} elseif (is_category()) {
		$url = get_category_link(get_queried_object()->term_id);

	} elseif(is_tax()) {
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
		$url = get_author_posts_url(get_queried_object()->term_id);
		
	} else {
		$url  = get_the_permalink(get_the_ID());
	}

	$url = esc_url($url) . '?' . $args;
 
  if( $pages_count > 0 ) : ?>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<?php
				echo '<li class="page-item"><a class="page-link" href="'.$url.'pg=1" aria-label="Previous"><span>&laquo;</span></a></li>';
				
				for($i = $current_page - $maxLinks; $i <= $current_page - 1; $i++):
					if($i >= 1):
						echo '<li><a class="page-link" href="'.$url.'pg='.$i.'">'.$i.'</a></li>';
					endif;
				endfor;

				echo '<li class="page-item active"><a class="page-link" href="'.$url.'pg='.$current_page.'"> '.$current_page.'</a></li>';
				
				for($i = $current_page + 1; $i <= $current_page + $maxLinks; $i++):
					if($i <= $pages_count):
						echo '<li class="page-item"><a class="page-link" href="'.$url.'pg='.$i.'">'.$i.'</a></li>';
					endif;
				endfor;

				echo '<li class="page-item"><a class="page-link" href="'.$url.'pg='.$pages_count.'" aria-label="Next"><span>&raquo;</span></a></li>';
				?>
			</ul>
		</nav>
<?php endif;
}
