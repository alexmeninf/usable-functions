<nav class="drawer-mobile" id="drawer">
	<span class="close-menu" aria-label="Fechar">
		<i class="fal fa-times"></i>
	</span>
	<div class="wrap backdrop-filter">
		<div class="wrapper-form">
			<?php get_search_form(); ?>
			<a class="searchfield_cancel">cancelar</a>
		</div>

		<div class="img-brand">
			<a href="<?php echo get_home_url() ?>" title="<?php bloginfo('name') ?>">
				<?php apply_filters('logo_tema', null) ?>
			</a>
		</div>

		<?php
		wp_nav_menu(
			array(
			'theme_location'  => 'primary',
			'container'       => 'div',
			'container_class' => '',
			'menu_class'      => 'header-menu'
			)
		); ?>
		
	</div>
</nav>