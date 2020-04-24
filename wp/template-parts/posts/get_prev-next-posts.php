<?php
$previous = get_previous_post();
$next     = get_next_post();
?>

<div class="nav-previous">
  <?php if ( get_previous_post() ) { ?>
    <a href="<?= get_the_permalink($previous) ?>"><< Post anterior</a>
  <?php } ?>
</div>

<div class="nav-next">
  <?php if ( get_next_post() ) { ?>
    <a href="<?= get_the_permalink($next) ?>">Próxima post >></a>
  <?php } ?>
</div>