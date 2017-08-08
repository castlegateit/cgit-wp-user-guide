<?php

namespace Cgit\UserGuide;

/**
 * User guide
 *
 * Assembles the user guide from all its component sections and renders or
 * prints it as HTML.
 */
class Guide
{
    /**
     * User guide page title
     *
     * @var string
     */
    private $title = 'User Guide';

    /**
     * Include a table of contents?
     *
     * @var boolean
     */
    private $index = true;

    /**
     * Raw section data
     *
     * The original, unmodified section data as a multidimensional array which
     * can be amended using WordPress filters.
     *
     * @var array
     */
    private $raws = [];

    /**
     * Section instances
     *
     * The processed and sanitized section data as an array of Section
     * instances, with the correct headings, content, and sort orders.
     *
     * @var array
     */
    private $sections = [];

    /**
     * Constructor
     *
     * Apply filters to the default page title and table of contents boolean
     * value, add and/or edit raw section data using a filter, and generate the
     * list of sanitized section instances from the raw section data.
     *
     * @return void
     */
    public function __construct()
    {
        $prefix = 'cgit_user_guide_';

        // Apply filters to default values
        $this->title = apply_filters($prefix . 'page_title', $this->title);
        $this->index = apply_filters($prefix . 'has_index', $this->index);
        $this->raws = apply_filters($prefix . 'sections', $this->raws);

        // Generate the sanitized section instances
        $this->generateSectionInstances();
    }

    /**
     * Generate and sort sanitized section instances from raw section data
     *
     * @return void
     */
    private function generateSectionInstances()
    {
        foreach ($this->raws as $key => $args) {
            $this->sections[$key] = new Section($key, $args);
        }

        uasort($this->sections, function ($a, $b) {
            if ($a->order == $b->order) {
                return 0;
            }

            return $a->order < $b->order ? -1 : 1;
        });
    }

    /**
     * Render the user guide as HTML
     *
     * @return string
     */
    public function render()
    {
        $sections = [];

        // If it is enabled, the first section in the user guide should be the
        // table of contents.
        if ($this->index) {
            $sections[] = (new Index($this->sections))->render();
        }

        // Render each section as HTML and append them to the array of sections
        // to be output.
        foreach ($this->sections as $instance) {
            $sections[] = $instance->render();
        }

        // Render the complete user guide based on the appropriate template from
        // the views directory.
        $template = new Template('guide', [
            $this->title,
            implode(PHP_EOL, $sections),
        ]);

        return apply_filters('cgit_user_guide', $template->render());
    }

    /**
     * Print the user guide as HTML
     *
     * @return void
     */
    public function publish()
    {
        echo $this->render();
    }
}
