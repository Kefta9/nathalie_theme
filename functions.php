<?php
// Chargement des scripts et styles du thème enfant
function nathalie_theme_enqueue_assets() {
    wp_enqueue_style('space-mono-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
    wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
    wp_enqueue_style('nathalie-theme-style', get_stylesheet_uri());
    wp_enqueue_style('nathalie-theme-custom', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('nathalie-theme-header', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('nathalie-theme-footer', get_template_directory_uri() . '/assets/css/footer.css');
    wp_enqueue_style('nathalie-theme-modal-contact', get_template_directory_uri() . '/assets/css/modal_contact.css');
    wp_enqueue_style('nathalie-theme-single-photo', get_template_directory_uri() . '/assets/css/single_photo.css');
    wp_enqueue_script('nathalie-theme-global', get_template_directory_uri() . '/assets/scripts/global.js', array('jquery'), null, true);
    wp_enqueue_script('nathalie-theme-burger', get_template_directory_uri() . '/assets/scripts/burger.js', array(), null, true);
    wp_enqueue_script('nathalie-theme-modal', get_template_directory_uri() . '/assets/scripts/modal.js', array(), null, true);
    wp_enqueue_script('nathalie-theme-nav-hover', get_template_directory_uri() . '/assets/scripts/nav-hover.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'nathalie_theme_enqueue_assets');

// Déclaration du menu principal
add_action('after_setup_theme', function() {
    register_nav_menus([
        'main_menu'   => 'Menu principal',
        'footer_menu' => 'Menu footer',
    ]);
});