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

add_action('plugins_loaded', function() {
    define('CGIT_USER_GUIDE_PLUGIN_URL', plugin_dir_url(__FILE__));

    include dirname(__FILE__) . '/user-guide.php';
    include dirname(__FILE__) . '/functions.php';
    include dirname(__FILE__) . '/default-sections.php';
    include dirname(__FILE__) . '/legacy.php';

    Cgit\UserGuide::getInstance();
});
