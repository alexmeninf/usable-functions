<?php
/*====================================
=            OPTIONS PAGE            =
====================================*/
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title'  => 'Opções',
		'menu_title'  => 'Opções',
		'menu_slug'   => 'opcoes',
		'capability'  => 'edit_posts',
		'redirect'    => false
	));
}
