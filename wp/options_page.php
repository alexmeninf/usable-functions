<?php
/*====================================
=            OPTIONS PAGE            =
====================================*/
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title'  => __('Opções do site', 'menin'),
		'menu_title'  => __('Opções do site', 'menin'),
		'menu_slug'   => 'opcoes',
		'capability'  => 'edit_posts',
		'redirect'    => false
	));
}
