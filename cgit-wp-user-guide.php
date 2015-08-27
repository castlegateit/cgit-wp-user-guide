<?php

/*

Plugin Name: Castlegate IT WP User Guide
Plugin URI: http://github.com/castlegateit/cgit-wp-user-guide
Description: Add a simple WordPress user guide to the admin panel.
Version: 3.0
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

namespace Cgit;

class UserGuide
{

    /**
     * Reference to the singleton instance of the class
     */
    private static $instance;

    /**
     * Constructor
     *
     * Private constructor adds actions to enqueue the plugin CSS and JavaScript
     * and to add the menu to the admin panel.
     */
    private function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_menu', array($this, 'add'));
    }

    /**
     * Return the singleton instance of the class
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Return the output of a PHP file as a string. This allows a section of the
     * user guide to include some dynamic content.
     */
    public static function getFile($file)
    {
        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Enqueue CSS and JavaScript
     */
    public function enqueueScripts($hook)
    {

        if ($hook != 'toplevel_page_cgit-user-guide') {
            return;
        }

        $url = plugin_dir_url(__FILE__);
        wp_enqueue_style('cgit-wp-user-guide', $url . 'css/user-guide.css');
        wp_enqueue_script('cgit-wp-user-guide', $url . 'js/user-guide.js');

    }

    /**
     * Render the user guide
     *
     * Each section is represented by an item in an array, which can be edited
     * with the 'cgit_user_guide_sections' filter.
     *
     * The title of the user guide can be edited using the
     * 'cgit_user_guide_title' filter. The HTML that appears between each
     * section can be edited using the 'cgit_user_guide_separator' filter.
     *
     * For backwards compatibility, this also checks for a custom user guide in
     * the theme directory. However, this should no longer be used to edit the
     * guide.
     */
    public function render()
    {

        // Apply filters to the title and content
        $title = apply_filters('cgit_user_guide_title', 'User Guide');
        $sep = apply_filters('cgit_user_guide_separator', '<hr />');
        $sections = apply_filters('cgit_user_guide_sections', array());

        // Assemble content from filtered array of sections
        $content = implode($sep, $sections);

        // Backwards compatible theme-based guide
        $file = get_stylesheet_directory() . '/user-guide.php';

        if (file_exists($file)) {
            $title = '';
            $content = self::getFile($file);
        }

        echo '<div class="wrap cgit-user-guide"> <h2>' . $title . '</h2>'
            . $content . '</div>';

    }

    /**
     * Add the user guide to the admin panel
     */
    public function add()
    {
        add_menu_page(
            'User Guide',
            'User Guide',
            'edit_pages',
            'cgit-user-guide',
            array($this, 'render'),
            'dashicons-editor-help'
        );
    }

}

UserGuide::getInstance();

/**
 * Add default user guide
 *
 * The default user guide can be overwritten by adding a section with the key
 * 'default' with a priority higher than 1.
 */
add_filter('cgit_user_guide_sections', function($sections) {

    $file = dirname(__FILE__) . '/user-guide.php';
    $sections['default'] = UserGuide::getFile($file);

    return $sections;

});
