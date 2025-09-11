<?php
get_header();
?>

<main id="main" class="site-main" role="main">
	<section class="home-hero">
		<?php
		$random_photos = get_photos_by_category([], 1, [], true);
		if (!empty($random_photos)) :
			$post = $random_photos[0];
			setup_postdata($post);
			$bg_url = get_the_post_thumbnail_url($post->ID, 'full');
		?>
			<div class="home-hero__bg">
				<img src="<?php echo esc_url($bg_url); ?>" alt="Image de fond aléatoire" />
			</div>
		<?php wp_reset_postdata(); endif; ?>

		<div class="home-hero__content">
			<h1 class="hero__title">Photographe Event</h1>
		</div>
	</section>
	<section class="photo-gallery">
		<!-- Titre nécessaire pour le SEO -->
		<h2 class="visually-hidden">Galerie</h2>

		<!-- Filtres -->
		<form method="get" class="photo-gallery__filters">
			<!-- Catégories -->
			<select name="categorie">
				<option value="">Catégorie</option>
				<option value="reception">Réception</option>
				<option value="television">Télévision</option>
				<option value="concert">Concert</option>
				<option value="mariage">Mariage</option>
			</select>

			<!-- Formats -->
			<select name="format">
				<option value="">Format</option>
				<option value="paysage">Paysage</option>
				<option value="portrait">Portrait</option>
			</select>

			<!-- Tri -->
			<select name="order">
				<option value="">Trier par</option>
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
	</section>

</main>

<?php get_footer(); ?>