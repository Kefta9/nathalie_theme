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
      // ---------- NAVIGATION PAR CATÉGORIE UNIQUEMENT ----------
      $main_thumb = get_the_post_thumbnail_url($current_post_id, 'thumbnail');

      // IDs de catégories de la photo courante
      $current_cat_ids = ($cats && !is_wp_error($cats)) ? wp_list_pluck($cats, 'term_id') : [];

      // Récupère toutes les photos de la/les même(s) catégorie(s), triées
      $category_posts = [];
      if ( !empty($current_cat_ids) ) {
        $category_posts = get_posts([
          'post_type'      => 'photo',
          'posts_per_page' => -1,
          'orderby'        => 'date',
          'order'          => 'ASC',
          'tax_query'      => [[
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $current_cat_ids,
          ]],
          'fields'         => 'ids', // perf : on ne récupère que les IDs
        ]);
      }

      // S'assurer que la photo courante est bien présente (sécurité si multiples taxos)
      if (!in_array($current_post_id, $category_posts, true)) {
        $category_posts[] = $current_post_id;
      }

      // Trouver l’index de la photo courante dans ce tableau catégorie
      $current_index = array_search($current_post_id, $category_posts, true);

      // Calculer prev/next dans CETTE liste (navigation circulaire)
      $count = count($category_posts);
      $show_arrows = ($count > 1);

      if ($show_arrows) {
        $prev_index = ($current_index > 0) ? $current_index - 1 : $count - 1;
        $next_index = ($current_index < $count - 1) ? $current_index + 1 : 0;

        $prev_id = $category_posts[$prev_index];
        $next_id = $category_posts[$next_index];

        $prev_thumb = get_the_post_thumbnail_url($prev_id, 'thumbnail');
        $next_thumb = get_the_post_thumbnail_url($next_id, 'thumbnail');
      }
      ?>

      <!-- Navigation flèches (catégorie only) -->
      <?php if ($show_arrows): ?>
      <div class="single-photo__nav">
        <!-- Miniature -->
        <img src="<?php echo esc_url($main_thumb); ?>" class="nav-preview-single" data-default="<?php echo esc_url($main_thumb); ?>" alt="" />
        
        <div class="nav-arrows">
          <a
            href="<?php echo esc_url(get_permalink($prev_id)); ?>"
            class="nav-link nav-prev"
            aria-label="Photo précédente dans la même catégorie"
            data-thumbnail-hover="<?php echo esc_url($prev_thumb); ?>"
          >←</a>

          <a
            href="<?php echo esc_url(get_permalink($next_id)); ?>"
            class="nav-link nav-next"
            aria-label="Photo suivante dans la même catégorie"
            data-thumbnail-hover="<?php echo esc_url($next_thumb); ?>"
          >→</a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- SECTION 2 : Autres photos -->
  <section class="other-photos"></section>

</main>
<?php
endwhile; endif;

get_footer();
