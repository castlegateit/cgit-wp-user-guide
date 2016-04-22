<?php

/*

Plugin Name: Castlegate IT WP User Guide
Plugin URI: http://github.com/castlegateit/cgit-wp-user-guide
Description: Add a simple WordPress user guide to the admin panel.
Version: 4.1
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

require __DIR__ . '/src/autoload.php';

define('CGIT_USER_GUIDE_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load plugin
add_action('plugins_loaded', function() {
    require __DIR__ . '/functions.php';
    require __DIR__ . '/defaults.php';
    require __DIR__ . '/legacy.php';

    // Initialization
    Cgit\UserGuide::getInstance();
});
