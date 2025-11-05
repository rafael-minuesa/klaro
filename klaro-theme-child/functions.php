<?php
/**
 * Enqueue parent and child theme styles
 */
function klaro_child_enqueue_styles() {
    $parent_style = 'klaro-style'; // Try to match the handle used in the parent theme

    // Load the parent style first
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');

    // Then load the child style
    wp_enqueue_style(
        'klaro-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'klaro_child_enqueue_styles');
