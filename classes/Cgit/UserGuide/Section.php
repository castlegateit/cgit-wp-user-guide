<?php

namespace Cgit\UserGuide;

/**
 * User guide section
 *
 * Used to sanitize, format, and render each section that makes up the user
 * guide. Attempts to fill in missing headings and sort order properties based
 * on the user guide content and default values respectively.
 */
class Section
{
    /**
     * Unique identifier for this user guide section
     *
     * @var string
     */
    public $id;

    /**
     * Heading
     *
     * @var string
     */
    public $heading;

    /**
     * Section content as HTML
     *
     * @var string
     */
    public $content;

    /**
     * Sort order
     *
     * @var integer
     */
    public $order;

    /**
     * Constructor
     *
     * Assign required section values to properties and make sure they have
     * valid values.
     *
     * @param string $id
     * @param array $args
     * @return void
     */
    public function __construct($id, $args)
    {
        // Ensure that all necessary array keys exist
        $args = wp_parse_args($args, [
            'heading' => '',
            'content' => '',
            'order' => 10,
        ]);

        // Assign values to properties
        $this->id = 'cgit-user-guide-section-' . $id;
        $this->heading = $args['heading'];
        $this->content = $args['content'];
        $this->order = $args['order'];

        // Sanitize section data
        $this->sanitize();
    }

    /**
     * Sanitize required properties
     *
     * @return void
     */
    private function sanitize()
    {
        $this->sanitizeHeading();
        $this->sanitizeOrder();
    }

    /**
     * Sanitize section heading
     *
     * If the content contains a heading, use that as the section heading and
     * remove it from the content.
     *
     * @return void
     */
    private function sanitizeHeading()
    {
        if ($this->heading) {
            return;
        }

        $pattern = '/<(h[1-6])[^>]*>(.+?)<\/\1>/i';
        $match = preg_match($pattern, $this->content, $matches);

        if (!isset($matches[2]) || !$matches[2]) {
            return;
        }

        $this->heading = strip_tags($matches[2]);
        $this->content = preg_replace($pattern, '', $this->content, 1);
    }

    /**
     * Make sure that the sort order value is an integer
     *
     * @return void
     */
    private function sanitizeOrder()
    {
        $this->order = intval($this->order);
    }

    /**
     * Render section as HTML
     *
     * Loads the section template from the views directory, formats it with the
     * necessary values, and returns the result as an HTML string.
     *
     * @return string
     */
    public function render()
    {
        $template = new Template('section', [
            $this->id,
            $this->heading,
            $this->content,
        ]);

        return $template->render();
    }
}
