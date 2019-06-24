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


<?php endwhile; endif; wp_reset_query(); ?>

// FUNCTION


/*==================================
=            PAGINATION            =
==================================*/
/**
 *
 * $current_page - Página atual
 * $pages_count - total de páginas de posts
 * $maxLinks - tamanho da paginação (A esqueda e a direita) Default = 2
 */
function get_pagination($current_page, $pages_count, $maxLinks = 2) {
	//Limite de link antes e depois
    if( $pages_count > 0 ) : ?>
        <!-- Pagination -->
        <div class="styled-pagination">
            <ul class="clearfix">
            <?php
            echo '<li class="prev"><a href="'.get_the_permalink(get_the_ID()).'"?pg=1" aria-label="Previous"><span>&laquo;</span></a></li>';
            for($i = $current_page - $maxLinks; $i <= $current_page - 1; $i++):
                if($i >= 1):
                    echo '<li><a href="'.get_the_permalink(get_the_ID()).'?pg='.$i.'">'.$i.'</a></li>';
                endif;
            endfor;

            echo '<li class="active"><a href="'.get_the_permalink(get_the_ID()).'?pg='.$current_page.'"> '.$current_page.'</a></li>';

            for($i = $current_page + 1; $i <= $current_page + $maxLinks; $i++):
                if($i <= $pages_count):
                    echo '<li><a href="'.get_the_permalink(get_the_ID()).'?pg='.$i.'">'.$i.'</a></li>';
                endif;
            endfor;
            echo '<li class="next"><a class="page-link" href="'.get_the_permalink(get_the_ID()).'?pg='.$pages_count.'" aria-label="Next"><span>&raquo;</span></a></li>';
            ?>
            </ul>
        </div>
    <?php endif;
}
