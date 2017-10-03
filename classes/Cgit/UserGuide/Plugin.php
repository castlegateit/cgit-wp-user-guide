<?php

namespace Cgit\UserGuide;

class Plugin
{
    /**
     * Constructor
     *
     * Instantiate the user guide and menu page that will be used to display the
     * user guide. Create the default user guide sections.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
        add_filter('cgit_user_guide', [$this, 'registerLegacyUserGuide']);
    }

    /**
     * Register legacy user guide
     *
     * In ancient versions of this plugin, the user guide was a single PHP file
     * placed in the active theme directory. This replicates that functionality
     * for backward compatibility. However, this should not be used to register
     * new user guides and this functionality will be removed in future.
     *
     * @deprecated 5.0
     * @param string $guide
     * @return string
     */
    public function registerLegacyUserGuide($guide)
    {
        $path = get_stylesheet_directory() . '/user-guide.php';

        if (!file_exists($path)) {
            return $guide;
        }

        return \Cgit\UserGuide\Content::load($path);
    }

    /**
     * Initialization
     *
     * @return void
     */
    public function init()
    {
        $defaults = new Defaults;
        $guide = new Guide;
        $admin = new Admin($guide);
    }
}
