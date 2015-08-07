<?php

/*

Plugin Name: Castlegate IT WP User Guide
Plugin URI: http://github.com/castlegateit/cgit-wp-user-guide
Description: Add a simple WordPress user guide to the admin panel.
Version: 2.0
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

/**
 * Return PHP file output as string
 */
function cgit_get_user_guide($file) {
    ob_start();
    include $file;
    return ob_get_clean();
}

/**
 * Add additional CSS
 */
function cgit_user_guide_styles($hook) {

    if ($hook != 'toplevel_page_cgit-user-guide') {
        return;
    }

    $file = plugin_dir_url(__FILE__) . 'css/user-guide.css';
    wp_enqueue_style('cgit-wp-user-guide', $file);

}

add_action('admin_enqueue_scripts', 'cgit_user_guide_styles');

/**
 * Add default user guide
 *
 * The default user guide can be overwritten by adding a section with the key
 * 'default' with a priority higher than 1.
 */
function cgit_add_default_user_guide($sections) {

    $file = dirname(__FILE__) . '/user-guide.php';
    $sections['default'] = cgit_get_user_guide($file);

    return $sections;

}

add_filter('cgit_user_guide_sections', 'cgit_add_default_user_guide', 1);

/**
 * Render user guide
 *
 * Each section is represented by an item in an array, which can be edited with
 * the 'cgit_user_guide_sections' filter.
 *
 * The title of the user guide can be edited using the 'cgit_user_guide_title'
 * filter. The HTML that appears between each section can be edited using the
 * 'cgit_user_guide_separator' filter.
 *
 * For backwards compatibility, this also checks for a custom user guide in the
 * theme directory. However, this should no longer be used to edit the guide.
 */
function cgit_render_user_guide () {

    // Get title and content using filters
    $title = apply_filters('cgit_user_guide_title', 'User Guide');
    $sep = apply_filters('cgit_user_guide_separator', '<hr />');
    $sections = apply_filters('cgit_user_guide_sections', array());

    // Assemble content from filtered array of sections
    $content = implode($sep, $sections);

    // Backwards compatible theme-based guide
    $file = get_stylesheet_directory() . '/user-guide.php';

    if (file_exists($file)) {
        $title = '';
        $content = cgit_get_user_guide($file);
    }

    echo '<div class="wrap cgit-user-guide"> <h2>' . $title . '</h2>'
        . $content . '</div>';

}

/**
 * Add user guide menu page
 */
function cgit_add_user_guide () {
    add_menu_page(
        'User Guide',
        'User Guide',
        'edit_pages',
        'cgit-user-guide',
        'cgit_render_user_guide',
        'dashicons-editor-help'
    );
}

add_action('admin_menu', 'cgit_add_user_guide');
