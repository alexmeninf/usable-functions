<?php
$post_tags = get_the_tags();

if ( $post_tags ) { 
  $numItems = count($post_tags);
  $i = 0;
?>
  <ul>
    <?php 
    foreach( $post_tags as $tag ) {
      echo '<li><a href="'.get_tag_link($tag->term_id).'">#'.$tag->name . '</a></li>';
      
      if(++$i !== $numItems) {
        echo ', ';
      }
    } ?>
  </ul>
<?php } ?>