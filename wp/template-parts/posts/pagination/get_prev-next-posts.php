<?php
$previous = get_previous_post();
$next     = get_next_post();
?>

<div class="pagination-posts">
  <?php if ( get_previous_post() ) { ?>
    <a href="<?= get_the_permalink($previous) ?>" title="Lê postagem: <?= get_the_title($previous) ?>" class="nav-previous">
      <i class="far fa-chevron-double-left"></i> 
      <span>Anterior</span>
    </a>
  <?php } ?>

  <?php if ( get_next_post() ) { ?>
    <a href="<?= get_the_permalink($next) ?>" title="Lê postagem: <?= get_the_title($next) ?>" class="nav-next">
      <span>Próxima</span> 
      <i class="far fa-chevron-double-right"></i>
    </a>
  <?php } ?>
</div>
