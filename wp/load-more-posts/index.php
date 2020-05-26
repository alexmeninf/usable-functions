<html>
  <head>
    <meta name="getURL" content="<?php bloginfo('url') ?>">
  </head>

  <body>
    <?php 
    global $wp_query;
    $posts_total    = new WP_Query(array('post_type' => 'post', 'posts_per_page' => -1));
    $posts_count    = $posts_total->post_count;//total de posts
    $posts_per_page = 3; // o valor deve ser igual no functions.php
    $pages_count    = ceil($posts_count / $posts_per_page);
    ?>
    <main
      class="posts-list"
      data-page="<?= get_query_var('paged') ? get_query_var('paged') : 1; ?>"
      data-max="<?= $pages_count; ?>"
    >
    <?php 
    $loop = new WP_Query(array('post_type' => 'post', 'order' => 'asc', 'posts_per_page' => $posts_per_page));
      if ($loop->have_posts()) : ?>
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
          <?php the_title() ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </main>


    <button class="load-more-button" type="button">
      <span>Mais notícias</span>
    </button>
  </body>
</html>
