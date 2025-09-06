<article class="photo-block">
  <a href="<?php the_permalink(); ?>" class="photo-block__link">
    <?php if (has_post_thumbnail()): ?>
      <?php the_post_thumbnail('medium', ['class' => 'photo-block__img', 'loading' => 'lazy']); ?>
    <?php endif; ?>
  </a>
</article>
