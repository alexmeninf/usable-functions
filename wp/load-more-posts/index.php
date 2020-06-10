<html>
  <head>
      <meta name="themeroot" content="<?= THEMEROOT ?>">
      <meta name="getURL" content="<?php bloginfo('url') ?>">
      <meta name="currentUrl" content="<?php the_permalink() ?>">
  </head>

  <body>
    <?php 
    global $wp_query;
    $offset = 3;
    $posts_per_page = 8;
    $posts_total    = new WP_Query(array('post_type' => 'post', 'posts_per_page' => -1));
    $posts_count    = $posts_total->post_count;//total de posts
    $pages_count    = ceil($posts_count / $posts_per_page);
    ?>
    <main
      class="posts-list"
      data-page="<?= get_query_var('paged') ? get_query_var('paged') : 1; ?>"
      data-max="<?= $pages_count; ?>"
      data-offset="<?= $offset ?>"
      data-per_page="<?= $posts_per_page ?>"
    >
    <?php 
    $loop = new WP_Query(array('post_type' => 'post', 'order' => 'desc', 'offset' => $offset, 'ignore_sticky_posts' => 1,'posts_per_page' => $posts_per_page));
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
