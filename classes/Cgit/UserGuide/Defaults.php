<?php

namespace Cgit\UserGuide;

/**
 * Default user guide sections
 *
 * Registers the basic default user guide sections that should be added to all
 * WordPress sites.
 */
class Defaults
{
    /**
     * Default user guide sections
     *
     * @var array
     */
    private $sections = [
        'dashboard' => 'Dashboard',
        'posts' => 'Posts and pages',
        'editor' => 'Editing content',
    ];

    /**
     * Constructor
     *
     * Add the default user guide section to the menu page using the sections
     * filter run in the Guide class.
     *
     * @return void
     */
    public function __construct()
    {
        add_filter('cgit_user_guide_sections', [$this, 'register']);
    }

    /**
     * Register the default sections
     *
     * @return void
     */
    public function register($sections)
    {
        $path = dirname(CGIT_USER_GUIDE_PLUGIN) . '/defaults/';
        $order = 1;

        foreach ($this->sections as $key => $name) {
            $sections[$key] = [
                'heading' => $name,
                'content' => Content::load($path . $key . '.php'),
                'order' => $order,
            ];

            $order++;
        }

        return $sections;
    }
}
