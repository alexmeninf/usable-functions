function load_more_posts() {
	header("Content-Type: text/html");

	$next_page = $_POST['current_page'] + 1;
	$max_pages = $_POST['max_pages'];
	$offset_pages = $_POST['offset_pages'];
	$per_page = $_POST['per_page'];

  $query = new WP_Query([
		'post_type'      => 'post',
		'offset'         => $offset_pages + $per_page,
    'posts_per_page' => $per_page,
    'paged'          => $next_page
  ]);
	if ($query->have_posts()) :

    ob_start();

		while ($query->have_posts()) : $query->the_post();

			get_template_part('template-parts/post/cards/item-post');

		endwhile;

		$result = ob_get_contents();
		ob_end_clean();
		
  else :

    wp_send_json_error('<div class="mt-5">Você chegou ao fim. :)</div>');

	endif;

	wp_reset_postdata();

	wp_send_json_success($result);
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
