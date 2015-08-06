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
 * Render user guide
 */
function cgit_render_user_guide () {

    $file = get_stylesheet_directory() . '/user-guide.php';

    echo '<div class="wrap" style="max-width: 60em;">';

    if ( file_exists($file) ) {
        include $file;
    } else {
        include dirname( __FILE__ ) . '/user-guide.php';
    }

    echo '</div>';

}

/**
 * Add user guide menu page
 */
function cgit_add_user_guide () {
    add_menu_page('User Guide', 'User Guide', 'edit_pages', 'cgit-user-guide', 'cgit_render_user_guide', 'dashicons-editor-help');
}

add_action('admin_menu', 'cgit_add_user_guide');
