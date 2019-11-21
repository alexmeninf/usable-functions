<?php

function the_products_categories() {
	$cat_level_1 = get_terms(
		'product_cat', array(
		'hide_empty' => true,
		'exclude' => [15],
		'parent' => 0
  ));

	foreach( $cat_level_1 as $cat_1 ) :
		echo '
		<li>
			<a href="'.get_term_link($cat_1->term_id).'" class="megamenu-title">'.$cat_1->name.'</a>';

				$cat_level_2 = get_terms('product_cat', array(
					'hide_empty' => false,
					'parent' => $cat_1->term_id
				));

				echo '
				<ul>
					<li><a href="'.get_term_link($cat_1->term_id).'">Ver os produtos</a></li>';
					foreach( $cat_level_2 as $cat_2 ) :
						echo '<li><a href="'.get_term_link($cat_2->term_id).'">'.$cat_2->name.'</a></li>';
					endforeach;
				echo '
				</ul>';

		echo '</li>';
	endforeach;
}
