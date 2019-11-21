<?php
  //Get tags of the products
  $tags = get_terms( array(
    'taxonomy' => 'product_tag', // get tags of products woocommerce
    'hide_empty' => true,
  ) );
  if ($tags): ?>
    <div>
      <?php
      $html = '<div>';
      foreach ( $tags as $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
        $html .= "<a href='{$tag_link}' title='Ver produtos da tag {$tag->name}'>";
        $html .= "{$tag->name}</a>";
      }
      $html .= '</div>';
      echo $html;?>
    </div>
  <?php endif ?>
