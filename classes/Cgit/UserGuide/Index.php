<?php

namespace Cgit\UserGuide;

/**
 * Index of user guide sections
 *
 * Provides a user guide section that contains a list of all the other sections
 * in the user guide.
 */
class Index
{
    /**
     * List of section instances
     *
     * @var array
     */
    private $sections = [];

    /**
     * List of entries in the table of contents
     *
     * @var array
     */
    private $items = [];

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($sections)
    {
        $this->sections = $sections;
        $this->generateItems();
    }

    /**
     * Generate the list of entries
     *
     * @return void
     */
    private function generateItems()
    {
        foreach ($this->sections as $section) {
            $this->items[$section->id] = $section->heading;
        }
    }

    /**
     * Render the table of contents
     *
     * @return string
     */
    public function render()
    {
        $items = [];

        foreach ($this->items as $key => $value) {
            $items[] = '<li><a href="#' . $key . '">' . $value . '</a></li>';
        }

        $template = new Template('index', [implode(PHP_EOL, $items)]);

        return $template->render();
    }
}
