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
</main>

<?php get_footer(); ?>