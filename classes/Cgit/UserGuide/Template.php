<?php

namespace Cgit\UserGuide;

/**
 * User guide page templates
 *
 * Loads, formats, and renders the various parts of the user guide page using
 * files in the views directory. This should not be used by other plugins.
 */
class Template
{
    /**
     * Template contents
     *
     * @var string
     */
    private $template;

    /**
     * Template parameters
     *
     * @var array
     */
    private $args;

    /**
     * Constructor
     *
     * Load the template from the views directory and assign its contents and
     * the template parameters to properties.
     *
     * @param string $name
     * @param array $args
     * @return void
     */
    public function __construct($name, $args = [])
    {
        $path = dirname(CGIT_USER_GUIDE_PLUGIN) . '/views/' . $name . '.php';

        // Does the template file exist?
        if (!file_exists($path)) {
            return trigger_error('Missing template: ' . $path);
        }

        // Load the template and assign it and any parameters to properties
        $this->template = file_get_contents($path);
        $this->args = $args;
    }

    /**
     * Render output from template
     *
     * Makes use of vsprintf to format the template with any parameters that
     * have been supplied.
     *
     * @return string
     */
    public function render()
    {
        return vsprintf($this->template, $this->args);
    }
}
