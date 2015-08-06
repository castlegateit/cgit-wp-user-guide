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
 * Add default user guide
 *
 * The default user guide can be overwritten by adding a section with the key
 * 'default' with a priority higher than the default value (10).
 */
function cgit_add_default_user_guide($sections) {

    $file = dirname(__FILE__) . '/user-guide.php';
    $sections['default'] = cgit_get_user_guide($file);

    return $sections;

}

add_filter('cgit_user_guide_sections', 'cgit_add_default_user_guide');

/**
 * Render user guide
 *
 * Each section is represented by an item in an array, which can be edited with
 * the 'cgit_user_guide_sections' filter.
 *
 * The title of the user guide can be edited using the 'cgit_user_guide_title'
 * filter. The HTML that appears between each section can be edited using the
 * 'cgit_user_guide_separator' filter.
 */
function cgit_render_user_guide () {

    $title = apply_filters('cgit_user_guide_title', 'User Guide');
    $sep = apply_filters('cgit_user_guide_separator', '<hr />');
    $sections = apply_filters('cgit_user_guide_sections', array());
    $content = implode($sep, $sections);

    echo '<div class="wrap" style="max-width: 60em;"> <h2>' . $title .
        $content . '</div>';

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
