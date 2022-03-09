<?php if (have_rows('redes_sociais', 'options')) : ?>
  <ul>
    <?php while (have_rows('redes_sociais', 'options')) : the_row(); ?>
    <li>
      <a href="<?php the_sub_field('link') ?>" rel="noreferrer" target="_blank" aria-label="Rede social"><i class="<?php the_sub_field('icone') ?>"></i></a>
    </li>
    <?php endwhile; ?>
  </ul>
</div>
<?php endif; ?>