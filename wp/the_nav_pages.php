<?php

function the_nav_pages() {
	$sql_pages = new WP_Query(array('post_type' => 'page', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'asc'));

    if($sql_pages->have_posts()):
    	while($sql_pages->have_posts()):
    		$sql_pages->the_post();
			  if(is_page(get_the_ID())): ?>
				   <li class="nav-item active"><a class="nav-link" href="<?= get_the_permalink() ?>"><?php the_title() ?></a></li>
			  <?php else: ?>
				   <li class="nav-item"><a class="nav-link" href="<?= get_the_permalink() ?>"><?php the_title() ?></a></li>
			   <?php endif;
    	endwhile;
	endif;

	wp_reset_query();
}
