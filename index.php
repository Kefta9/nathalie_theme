<?php
get_header();
?>

<main id="main" class="site-main" role="main">
	<section class="home-hero">
			<?php
			$bg_url = wp_get_attachment_image_url(65, 'full');
			if ($bg_url) :
			?>
				<div class="home-hero__bg">
					<img src="<?php echo esc_url($bg_url); ?>" alt="Image de fond" />
				</div>
			<?php endif; ?>

		<div class="home-hero__content">
			<h1 class="hero__title">Photographe Event</h1>
		</div>
	</section>
	<section class="photo-gallery">
		<!-- Titre nécessaire pour le SEO -->
		<h2 class="visually-hidden">Galerie</h2>

		<!-- Filtres -->
		<form method="get" class="photo-gallery__filters">
			<select name="categorie">
				<option value="">Catégorie</option>
				<?php
				$categories = get_terms(['taxonomy' => 'categorie', 'hide_empty' => false]);
				foreach ($categories as $cat) {
					echo '<option value="' . esc_attr($cat->slug) . '">' . esc_html($cat->name) . '</option>';
				}
				?>
			</select>

			<select name="format">
				<option value="">Format</option>
				<?php
				$formats = get_terms(['taxonomy' => 'format', 'hide_empty' => false]);
				foreach ($formats as $format) {
					echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
				}
				?>
			</select>

			<select name="order">
				<option value="DESC">Les plus récentes</option>
				<option value="ASC">Les plus anciennes</option>
			</select>
		</form>

		<!-- Affichage des photos -->
		<div class="other-photos">
			<?php
			// Arguments corrigés : tous les posts, pas de variables non définies
			$other_photos = get_photos_by_category([], 8, [], true);

			if (!empty($other_photos)) :
			?>
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
		</div>
		<button id="load-more" class="load-more-button">Charger plus</button>
	</section>
</main>

<?php get_footer(); ?>