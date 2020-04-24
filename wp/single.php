<?php the_title() ?>

<?= get_author_name(); ?>

<?= get_the_date('d \d\e F, Y') ?>

<?php the_content() ?>

<?php get_template_part('template-parts/posts/get_share-links') ?>

<?php get_template_part('template-parts/posts/get_tags') ?>

<?php get_template_part('template-parts/posts/get_categories') ?>

<?php get_template_part('template-parts/posts/get_prev-next-posts') ?>
