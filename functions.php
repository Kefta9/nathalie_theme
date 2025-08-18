<?php
// Chargement des scripts et styles du thème enfant
function nathalie_theme_enqueue_assets() {
    wp_enqueue_style('nathalie-theme-style', get_stylesheet_uri());
    wp_enqueue_style('nathalie-theme-custom', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script('nathalie-theme-global', get_template_directory_uri() . '/assets/scripts/global.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'nathalie_theme_enqueue_assets');
