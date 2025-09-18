<?php

// Chargement des scripts et styles
function nathalie_theme_enqueue_assets() {
    // Fonts
    wp_enqueue_style('space-mono-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
    wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    // Styles
    wp_enqueue_style('nathalie-theme-style', get_stylesheet_uri());
    wp_enqueue_style('nathalie-theme-custom', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('nathalie-theme-header', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('nathalie-theme-footer', get_template_directory_uri() . '/assets/css/footer.css');
    wp_enqueue_style('nathalie-theme-modal-contact', get_template_directory_uri() . '/assets/css/modal_contact.css');
    wp_enqueue_style('nathalie-theme-single-photo', get_template_directory_uri() . '/assets/css/single_photo.css');
    wp_enqueue_style('nathalie-theme-photo-block', get_template_directory_uri() . '/assets/css/photo_block.css');

    // Scripts
    wp_enqueue_script('nathalie-theme-global', get_template_directory_uri() . '/assets/scripts/global.js', array(), null, true);
    wp_enqueue_script('nathalie-theme-burger', get_template_directory_uri() . '/assets/scripts/burger.js', array(), null, true);
    wp_enqueue_script('nathalie-theme-modal', get_template_directory_uri() . '/assets/scripts/modal.js', array(), null, true);
    wp_enqueue_script('nathalie-theme-nav-hover', get_template_directory_uri() . '/assets/scripts/nav-hover.js', array(), null, true);
    wp_enqueue_script('nathalie-theme-dropdown', get_template_directory_uri() . '/assets/scripts/dropdown.js', array(), null, true);

    // Script AJAX
    wp_enqueue_script('nathalie-theme-filters', get_template_directory_uri() . '/assets/scripts/filters.js', array(), null, true);

    wp_localize_script('nathalie-theme-filters', 'nathalie_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('nathalie_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'nathalie_theme_enqueue_assets');

// Déclaration du menu principal
add_action('after_setup_theme', function() {
    register_nav_menus([
        'main_menu'   => 'Menu principal',
        'footer_menu' => 'Menu footer',
    ]);
});

// Fonction utilitaire pour récupérer les photos
function get_photos_by_category($category_ids = [], $limit = -1, $exclude = [], $random = false) {
    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => $limit,
        'orderby'        => $random ? 'rand' : 'date',
        'order'          => $random ? '' : 'ASC',
    ];

    if (!empty($exclude)) {
        $args['post__not_in'] = $exclude;
    }

    if (!empty($category_ids)) {
        $args['tax_query'] = [[
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $category_ids,
        ]];
    }

    return get_posts($args);
}

// AJAX : Charger plus / Filtres

function load_more_photos_callback() {
    check_ajax_referer('nathalie_ajax_nonce', 'nonce');

    $paged     = intval($_POST['page']) ?: 1;
    $per_page  = 8;
    $categorie = sanitize_text_field($_POST['categorie']); // sécurité pour nettoyer les données reçues par le choix de l'utilisateur
    $format    = sanitize_text_field($_POST['format']);
    $order     = sanitize_text_field($_POST['order']);
    $random    = empty($categorie) && empty($format) && empty($order);

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
    );

    if ($random) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'date';
        $args['order']   = $order ?: 'DESC';
    }

    $tax_query = array('relation' => 'AND'); 

    if (!empty($categorie)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (count($tax_query) > 1) { // Si au moins un filtre alors on affiche les photos correspondantes (relation AND)
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        ob_start();
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/photo_block');
        endwhile;
        wp_reset_postdata();
        $content = ob_get_clean();
        wp_send_json_success($content); // Renvoie le HTML généré
    else :
        wp_send_json_error('no_more');
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos_callback'); // appel ajax avec action=load_more_photos déclenche load_more_photos_callback()
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos_callback');
