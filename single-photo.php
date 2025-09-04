<?php
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
  $ref   = get_field('reference');
  $type  = get_field('type');
  $cats  = get_the_terms(get_the_ID(), 'categorie');
  $fmts  = get_the_terms(get_the_ID(), 'format');
  $year  = get_the_date('Y');
  $current_post_id = get_the_ID();
?>
<main class="single-photo">

  <!-- SECTION 1 : Infos + Grande photo -->
  <section class="single-photo__main">
    <div class="single-photo__box">
      
      <!-- Col gauche -->
      <div class="single-photo__infos">
        <h1 class="single-photo__title"><?php the_title(); ?></h1>
        <?php if ($ref): ?><p>Référence : <?= esc_html($ref) ?></p><?php endif; ?>
        <?php if ($cats && !is_wp_error($cats)): ?>
          <p>Catégorie : <?= esc_html(join(', ', wp_list_pluck($cats, 'name'))) ?></p>
        <?php endif; ?>
        <?php if ($fmts && !is_wp_error($fmts)): ?>
          <p>Format : <?= esc_html(join(', ', wp_list_pluck($fmts, 'name'))) ?></p>
        <?php endif; ?>
        <?php if ($type): ?><p>Type : <?= esc_html($type) ?></p><?php endif; ?>
        <p>Année : <?= esc_html($year) ?></p>
      </div>

      <!-- Col droite -->
      <div class="single-photo__media">
        <?php the_post_thumbnail('large', ['class' => 'single-photo__img', 'loading' => 'lazy']); ?>
      </div>

    </div>

    <!-- CTA + Navigation -->
    <div class="single-photo__bottom">
      <!-- CTA Contact -->
      <div class="single-photo__cta">
        <p>Cette photo vous intéresse ?</p>
        <a href="#modal-contact" class="btn-contact" data-ref="<?= esc_attr($ref); ?>">Contact</a>
      </div>

      <?php
      // Récupère toutes les photos
      $all_photos = get_posts([
          'post_type' => 'photo',
          'posts_per_page' => -1,
          'orderby' => 'date',
          'order' => 'ASC'
      ]);

      // Index de la photo courante
      $current_index = array_search($current_post_id, array_column($all_photos, 'ID'));

      // Photo précédente et suivante
      $prev_post = ($current_index > 0) ? $all_photos[$current_index - 1] : end($all_photos);
      $next_post = ($current_index < count($all_photos) - 1) ? $all_photos[$current_index + 1] : reset($all_photos);

      $main_thumb = get_the_post_thumbnail_url($current_post_id, 'thumbnail');

      // Catégories courantes
      $current_cat_ids = $cats && !is_wp_error($cats) ? wp_list_pluck($cats, 'term_id') : [];
      ?>        

      <!-- Navigation flèches -->
      <div class="single-photo__nav">
        <!-- Miniature -->
        <img src="<?php echo esc_url($main_thumb); ?>" class="nav-preview-single" />
        <div class="nav-arrows">
          <?php if ($prev_post): ?>
            <?php
              $prev_hover_id = $prev_post->ID;
              $prev_hover_thumb = get_the_post_thumbnail_url($prev_hover_id, 'thumbnail');

              // Cherche une autre photo de la même catégorie
              if (!empty($current_cat_ids)) {
                  $related = get_posts([
                      'post_type' => 'photo',
                      'posts_per_page' => 1,
                      'post__not_in' => [$current_post_id],
                      'tax_query' => [[
                          'taxonomy' => 'categorie',
                          'field' => 'term_id',
                          'terms' => $current_cat_ids
                      ]]
                  ]);
                  if (!empty($related)) {
                      $prev_hover_thumb = get_the_post_thumbnail_url($related[0]->ID, 'thumbnail');
                      $prev_hover_id = $related[0]->ID;
                  }
              }
            ?>
            <a href="<?php echo get_permalink($prev_hover_id); ?>"
                class="nav-link nav-prev"
                data-thumbnail-hover="<?php echo esc_url($prev_hover_thumb); ?>"
                data-thumbnail-default="<?php echo esc_url($main_thumb); ?>"
                data-hover-id="<?php echo esc_attr($prev_hover_id); ?>">
              ←
            </a>
          <?php endif; ?>

          <?php if ($next_post): ?>
            <?php
              $next_hover_id = $next_post->ID;
              $next_hover_thumb = get_the_post_thumbnail_url($next_hover_id, 'thumbnail');

              if (!empty($current_cat_ids)) {
                  $related = get_posts([
                      'post_type' => 'photo',
                      'posts_per_page' => 1,
                      'post__not_in' => [$current_post_id],
                      'tax_query' => [[
                          'taxonomy' => 'categorie',
                          'field' => 'term_id',
                          'terms' => $current_cat_ids
                      ]]
                  ]);
                  if (!empty($related)) {
                      $next_hover_thumb = get_the_post_thumbnail_url($related[0]->ID, 'thumbnail');
                      $next_hover_id = $related[0]->ID;
                  }
              }
            ?>
            <a href="<?php echo get_permalink($next_hover_id); ?>"
                class="nav-link nav-next"
                data-thumbnail-hover="<?php echo esc_url($next_hover_thumb); ?>"
                data-thumbnail-default="<?php echo esc_url($main_thumb); ?>"
                data-hover-id="<?php echo esc_attr($next_hover_id); ?>">
              →
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 2 : Autres photos -->
  <section class="other-photos"></section>

</main>
<?php
endwhile; endif;

get_footer();
