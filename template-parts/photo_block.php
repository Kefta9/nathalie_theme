<?php
$categories = get_the_terms(get_the_ID(), 'categorie'); // Catégories des photos injectées par la function get_photos_by_category()
$category_name = !empty($categories) ? $categories[0]->name : '';
$full_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>
<article class="photo-block" data-photo-id="<?php echo get_the_ID(); ?>" data-category="<?php echo esc_attr($category_name); ?>" data-full-image="<?php echo esc_url($full_image_url); ?>">
    <?php if (has_post_thumbnail()): ?>
      <?php the_post_thumbnail('medium', ['class' => 'photo-block__img', 'loading' => 'lazy']); ?>
      <div class="photo-block__overlay">
        <a href="<?php the_permalink(); ?>" class="photo-block__fullscreen">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_fullscreen.svg" alt="Voir en plein écran">
        </a>
        <button class="photo-block__eye" aria-label="Ouvrir la lightbox">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Icon_eye.svg" alt="Agrandir">
        </button>
        <div class="photo-block__infos">
          <h3 class="photo-block__title"><?php the_title(); ?></h3>
          <span class="photo-block__category"><?php echo esc_html($category_name); ?></span>
          <span class="photo-block__ref"><?php the_field('reference'); ?></span>
        </div>
      </div>
    <?php endif; ?>
</article>
