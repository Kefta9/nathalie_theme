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
      // ---------- NAVIGATION PAR CATÉGORIE ----------
      $main_thumb = get_the_post_thumbnail_url($current_post_id, 'thumbnail');

      // ID de la première catégorie (si plusieurs, on prend la 1ère)
      $current_cat_id = ($cats && !is_wp_error($cats)) ? $cats[0]->term_id : null;

      // Récupère tous les posts de la même catégorie
      $category_posts = get_photos_by_category([$current_cat_id], -1);

      // Transformer en tableau d’IDs
      $category_ids = wp_list_pluck($category_posts, 'ID');

      // Sécurité : si jamais la photo courante n’est pas dans la liste
      if (!in_array($current_post_id, $category_ids, true)) {
        $category_ids[] = $current_post_id;
      }

      // Trouver l’index courant
      $current_index = array_search($current_post_id, $category_ids, true);

      // Calculer prev/next avec modulo
      $count = count($category_ids);
      $show_arrows = ($count > 1);

      if ($show_arrows) {
        $prev_index = ($current_index - 1 + $count) % $count;
        $next_index = ($current_index + 1) % $count;

        $prev_id = $category_ids[$prev_index];
        $next_id = $category_ids[$next_index];

        $prev_thumb = get_the_post_thumbnail_url($prev_id, 'thumbnail');
        $next_thumb = get_the_post_thumbnail_url($next_id, 'thumbnail');
      }
      ?>

      <!-- Navigation flèches -->
      <?php if ($show_arrows): ?>
      <div class="single-photo__nav">
        <!-- Miniature -->
        <img src="<?php echo esc_url($main_thumb); ?>" 
             class="nav-preview-single" 
             data-default="<?php echo esc_url($main_thumb); ?>" 
             alt="" />

        <div class="nav-arrows">
          <a href="<?php echo esc_url(get_permalink($prev_id)); ?>"
             class="nav-link nav-prev"
             aria-label="Photo précédente dans la même catégorie"
             data-thumbnail-hover="<?php echo esc_url($prev_thumb); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/left_arrow.svg" alt="Précédent" width="24" height="24" class="arrow-svg" />
          </a>

          <a href="<?php echo esc_url(get_permalink($next_id)); ?>"
             class="nav-link nav-next"
             aria-label="Photo suivante dans la même catégorie"
             data-thumbnail-hover="<?php echo esc_url($next_thumb); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right_arrow.svg" alt="Suivant" width="24" height="24" class="arrow-svg" />
          </a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- SECTION 2 : Autres photos -->
  <section class="other-photos">
  <?php
  $other_photos = get_photos_by_category([$current_cat_id], 2, [$current_post_id], true);

  if (!empty($other_photos)) :
  ?>
    <h2 class="other-photos__title">Vous aimerez aussi</h2>
    <div class="other-photos__grid">
      <?php
      foreach ($other_photos as $post) :
        setup_postdata($post);
        get_template_part('template-parts/photo_block');
      endforeach;
      wp_reset_postdata();
      ?>
    </div>
  <?php endif; ?>
</section>

</main>
<?php
endwhile; endif;

get_footer();
