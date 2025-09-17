<?php
get_header();
?>

<main id="main" class="site-main" role="main">
	<section class="home-hero">
			<?php
			$bg_url = wp_get_attachment_image_url(65, 'full'); /* Changer ID pour changer l'image (voir url des images) */
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
			<div class="custom-select" data-filter="categorie">
				<button type="button" class="custom-select__label" data-default="Catégorie">Catégorie</button>
				<ul class="custom-select__options">
					<?php
					$categories = get_terms(['taxonomy' => 'categorie', 'hide_empty' => false]);
					foreach ($categories as $cat) {
						echo '<li data-value="' . esc_attr($cat->slug) . '">' . esc_html($cat->name) . '</li>';
					}
					?>
				</ul>
				<input type="hidden" name="categorie" value="">
			</div>

			<div class="custom-select" data-filter="format">
				<button type="button" class="custom-select__label" data-default="Format">Format</button>
				<ul class="custom-select__options">
					<?php
					$formats = get_terms(['taxonomy' => 'format', 'hide_empty' => false]);
					foreach ($formats as $format) {
						echo '<li data-value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</li>';
					}
					?>
				</ul>
				<input type="hidden" name="format" value="">
			</div>

			<div class="custom-select" data-filter="order">
				<button type="button" class="custom-select__label">Trier</button>
				<ul class="custom-select__options">
					<li data-value="DESC">Les plus récentes</li>
					<li data-value="ASC">Les plus anciennes</li>
				</ul>
				<input type="hidden" name="order" value="DESC">
			</div>
		</form>

		<!-- Affichage des photos -->
		<div class="other-photos">
			<div class="other-photos__grid">
				<?php
				$other_photos = get_photos_by_category([], 8, [], true);
				if (!empty($other_photos)) :
					foreach ($other_photos as $post) :
						setup_postdata($post);
						get_template_part('template-parts/photo_block');
					endforeach;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>

		<button id="load-more" class="load-more-button">Charger plus</button>
	</section>
</main>

<?php get_footer(); ?>