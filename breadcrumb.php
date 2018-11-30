<?php
/*======================================
=            GET BREADCRUMB            =
======================================*/
function get_breadcrumb() {
    global $post;
    $class = ''; // Coloque o estilo da classe das <li> aqui
    echo '<ul>'; // customize sua <ul> aqui

    if ( !is_home() ) {
        echo '<li '.$class.'><a href="'.get_option('home').'">';
        echo 'Página Inicial';
        echo '</a></li>';

        if ( is_category() || is_single() ) {
            if( get_the_category() ) {
                echo '<li '.$class.'>&nbsp;';
                the_category(' </li><li '.$class.'> ');

                if ( is_single() ) {
                    echo '</li><li '.$class.'>&nbsp;';
                    the_title();
                    echo '</li>';
                }
            }else {
                echo "<li ".$class.">&nbsp;".get_the_title()."</li>";
            }

        } elseif ( is_page() ) {

            if($post->post_parent){
                $anc   = get_post_ancestors( $post->ID );
                $title = get_the_title();

                foreach ( $anc as $ancestor ) {
                    $output = '<li '.$class.'><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'"> '.get_the_title($ancestor).' </a></li>';
                }
                echo $output;
                echo ' <strong title="'.$title.'">&nbsp;'.$title.' </strong>';
            } else {
                echo '<li '.$class.'><strong>&nbsp;'.get_the_title().' </strong></li>';
            }
        }elseif ( is_404() ) {
            echo '<li '.$class.'>&nbsp;Página não encontrada </li>';
        }
    }

    elseif ( is_tag() ) {
        single_tag_title();
    }

    elseif ( is_day() ) {
        echo "<li ".$class.">&nbsp;Arquivo de ".the_time('j \d\e F \d\e Y')."</li>";
    }

    elseif ( is_month() ) {
        echo "<li ".$class.">&nbsp;Arquivo de ".the_time('F \d\e Y')."</li>";
    }

    elseif ( is_year() ) {
        echo "<li ".$class.">&nbsp;Arquivo de ".the_time('Y')."</li>";
    }

    elseif ( is_author() ) {
        echo "<li ".$class.">&nbsp;Arquivo do autor</li>";
    }

    elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) {
        echo "<li ".$class.">&nbsp;Arquivo do blog</li>";
    }

    elseif ( is_search() ) {
        echo "<li ".$class.">&nbsp;Resultados da pesquisa</li>";
    }
    echo '</ul>';
}
