<?php

/*

Plugin Name: Castlegate IT WP User Guide
Plugin URI: https://github.com/castlegateit/cgit-wp-user-guide
Description: Add a simple WordPress user guide to the admin panel.
Version: 5.2
Author: Castlegate IT
Author URI: https://www.castlegateit.co.uk/
License: MIT

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

define('CGIT_USER_GUIDE_PLUGIN', __FILE__);
define('CGIT_USER_GUIDE_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/lib/parsedown/Parsedown.php';
require_once __DIR__ . '/classes/autoload.php';

$plugin = new \Cgit\UserGuide\Plugin();

do_action('cgit_user_guide_plugin', $plugin);
do_action('cgit_user_guide_loaded');
