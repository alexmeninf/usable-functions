/*==================================
=            PAGINATION            =
==================================*/
/**
 *
 * $current_page - Página atual
 * $pages_count - total de páginas de posts
  * $maxLinks - tamanho da paginação (A esqueda e a direita) Default = 1
 */
function get_pagination($current_page, $pages_count, $maxLinks = 1) {
	//Limite de link antes e depois
    if( $pages_count > 0 ) : ?>
        <!-- Pagination -->
        <div class="styled-pagination">
            <ul class="clearfix">
            <?php
            echo '<li><a href="'.get_the_permalink(get_the_ID()).'"?pg=1" aria-label="Previous"><span>&laquo;</span></a></li>';
            for($i = $current_page - $maxLinks; $i <= $current_page - 1; $i++):
                if($i >= 1):
                    echo '<li><a href="'.get_the_permalink(get_the_ID()).'?pg=$i">$i</a></li>';
                endif;
            endfor;

            echo '<li class="active"><a href="'.get_the_permalink(get_the_ID()).'?pg='.$current_page.'"> '.$current_page.'</a></li>';

            for($i = $current_page + 1; $i <= $current_page + $maxLinks; $i++):
                if($i <= $pages_count):
                    echo '<li><a href="'.get_the_permalink(get_the_ID()).'?pg=$i">$i</a></li>';
                endif;
            endfor;
            echo '<li><a class="page-link" href="'.get_the_permalink(get_the_ID()).'?pg='.$pages_count.'" aria-label="Next"><span>&raquo;</span></a></li>';
            ?>
            </ul>
        </div>
    <?php endif;
} ?>
