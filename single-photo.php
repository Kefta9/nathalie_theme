<?php
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
  $ref   = get_field('reference');
  $type  = get_field('type');
  $cats  = get_the_terms(get_the_ID(), 'categorie');
  $fmts  = get_the_terms(get_the_ID(), 'format');
  $year  = get_the_date('Y'); // date native WP
?>
<main class="single-photo">

  <!-- SECTION 1 : Infos + Grande photo -->
  <section class="single-photo__main">
    <div class="single-photo__box">
      <!-- Col gauche -->
      <div class="single-photo__infos">
        <h1 class="single-photo__title"><?php the_title(); ?></h1>

        <?php if ($ref): ?>
          <p>Référence : <?= esc_html($ref) ?></p>
        <?php endif; ?>

        <?php if ($cats && !is_wp_error($cats)): ?> 
          <?php // join est un alias de implode, transforme le tableau en chaîne de caractère ?>
          <p>Catégorie : <?= esc_html(join(', ', wp_list_pluck($cats, 'name'))) ?></p> 
        <?php endif; ?> 

        <?php if ($fmts && !is_wp_error($fmts)): ?>
          <p>Format : <?= esc_html(join(', ', wp_list_pluck($fmts, 'name'))) ?></p>
        <?php endif; ?>

        <?php if ($type): ?>
          <p>Type : <?= esc_html($type) ?></p>
        <?php endif; ?>

        <p>Année : <?= esc_html($year) ?></p>
      </div>

      <!-- Col droite -->
      <div class="single-photo__media">
        <?php the_post_thumbnail('large', ['class' => 'single-photo__img', 'loading' => 'lazy']); ?>
      </div>
    </div>
  </section>

  <!-- SECTION 2 : Autres photos -->
  <section class="other-photos">

  </section>

</main>
<?php
endwhile; endif;

get_footer();
