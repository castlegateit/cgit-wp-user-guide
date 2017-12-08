<?php

namespace Cgit\UserGuide;

/**
 * WordPress menu page
 *
 * Registers and displays the user guide as a menu page in the Wordpress admin
 * panel. The menu title and icon and the user capabilities needed to view the
 * guide can be customized with filters.
 */
class Admin
{
    /**
     * Menu name
     *
     * @var string
     */
    private $name = 'cgit-user-guide';

    /**
     * Menu title
     *
     * @var string
     */
    private $title = 'About Website';

    /**
     * Minimum user capability required to view the menu
     *
     * @var string
     */
    private $cap = 'edit_pages';

    /**
     * Icon name
     *
     * The menu icon is loaded from the WordPress Dashicons font
     * <https://developer.wordpress.org/resource/dashicons/>.
     *
     * @var string
     */
    private $icon = 'dashicons-editor-help';

    /**
     * Filter name prefix
     *
     * @var string
     */
    private $prefix = 'cgit_user_guide_admin_menu_';

    /**
     * Guide class instance
     *
     * @var Guide
     */
    private $guide;

    /**
     * Constructor
     *
     * Applies filters to the title, user capability, and icon name to allow
     * customization. Registers the menu page that displays the user guide and
     * enqueue the necessary styles and scripts.
     *
     * @param Guide $guide Guide class instance
     * @return void
     */
    public function __construct($guide)
    {
        // Assign guide class instance to property
        $this->guide = $guide;

        // Customize menu title
        $this->title = 'About ' . get_option('blogname');

        // Apply filters to default menu page properties
        $this->title = apply_filters($this->prefix . 'title', $this->title);
        $this->cap = apply_filters($this->prefix . 'cap', $this->cap);
        $this->icon = apply_filters($this->prefix . 'icon', $this->icon);

        // Register the menu page, styles, and scripts
        add_action('admin_menu', [$this, 'registerMenu']);
        add_action('admin_enqueue_scripts', [$this, 'registerScripts']);
    }

    /**
     * Register menu
     *
     * Registers the menu page that displays the user guide. This method must be
     * run on the "admin_menu" action. If the Video User Manuals plugin is
     * installed, this becomes a child page of that plugin's menu.
     *
     * @return void
     */
    public function registerMenu()
    {
        // Add sub-menu to Video User Manuals
        if (defined('VUM_PLUGIN_DIR')) {
            return add_submenu_page('video-user-manuals/plugin.php',
                $this->title, $this->title, $this->cap, $this->name,
                [$this->guide, 'publish']);
        }

        // Add top level menu page
        add_menu_page($this->title, $this->title, $this->cap, $this->name,
            [$this->guide, 'publish'], $this->icon);
    }

    /**
     * Register styles and scripts
     *
     * Enqueues the styles and scripts necessary to format the custom elements
     * of the user guide menu page.
     *
     * @return void
     */
    public function registerScripts($hook)
    {
        // Restrict the styles to the user guide page, which may be a top level
        // page or, if Video User Manuals is installed, a sub-page.
        if ($hook != 'toplevel_page_' . $this->name &&
            $hook != 'manual_page_' . $this->name) {
            return;
        }

        $url = plugin_dir_url(CGIT_USER_GUIDE_PLUGIN);

        wp_enqueue_script($this->name, $url . '/js/script.js');
        wp_enqueue_style($this->name, $url . '/css/style.css');
    }
}
