<?php 

function the_breadcrumb($tag_list = '<ul>', $class='') {
	global $post;
	
	if (!empty($class) && trim($class) != '') {
		$class = 'class="' . $class . '"';
	}

	if( !(is_home() || is_front_page())) {
		echo $tag_list;
		echo '<li '.$class.'><a href="'.get_option('home').'">';
		echo 'Início';
		echo '</a></li>';

		if (is_category() || is_single()) {
			if(get_the_category()) {
				echo '<li '.$class.'>&nbsp;';
				the_category(' </li><li '.$class.'> ');

				if (is_single()) {
					echo '</li><li '.$class.'>&nbsp;';
					the_title();
					echo '</li>';
				}
			}	else {
				echo "<li ".$class.">&nbsp;".get_the_title()."</li>";
			}
		}	elseif (is_page()) {
			if($post->post_parent) {
				$anc=get_post_ancestors($post->ID);
				$title=get_the_title();

				foreach ($anc as $ancestor) {
					$output='<li '.$class.'><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'"> '.get_the_title($ancestor).' </a></li>';
				}

				echo $output;
				echo ' <strong title="'.$title.'">&nbsp;'.$title.' </strong>';
			}	else {
				echo '<li '.$class.'><strong>&nbsp;'.get_the_title().' </strong></li>';
			}
		} elseif (is_404()) {
			echo '<li '.$class.'>&nbsp;Página não encontrada </li>';
		} elseif (is_tag()) {
			echo "<li ".$class.">";
			single_tag_title();
			echo "</li>";
		} elseif (is_tax()) {
			$term=get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			echo "<li ".$class.">".$term->name."</li>";
		} elseif (is_day()) {
			echo "<li ".$class.">&nbsp;Arquivo de ".get_the_time('j \d\e F \d\e Y')."</li>";
		} elseif (is_month()) {
			echo "<li ".$class.">&nbsp;Arquivo de ".get_the_time('F \d\e Y')."</li>";
		} elseif (is_year()) {
			echo "<li ".$class.">&nbsp;Arquivo de ".get_the_time('Y')."</li>";
		} elseif (is_author()) {
			echo "<li ".$class.">&nbsp;Arquivo do autor</li>";
		} elseif (isset($_GET['p']) && !empty($_GET['p'])) {
			echo "<li ".$class.">&nbsp;Arquivo do blog</li>";
		} elseif (is_search()) {
			echo "<li ".$class.">&nbsp;Resultados da pesquisa</li>";
		} if(strstr($tag_list, '<ul')) {
			echo '</ul>';
		} else {
			echo '</ol>';
		}
	}
}
