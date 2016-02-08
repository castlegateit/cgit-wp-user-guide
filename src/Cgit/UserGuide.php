<?php

namespace Cgit;

/**
 * Generate a user guide
 */
class UserGuide
{
    /**
     * Reference to the singleton instance of the class
     */
    private static $instance;

    /**
     * Sections
     *
     * Each section should consist of an array, with keys for heading, content,
     * and order.
     */
    private $sections = [];

    /**
     * Generate table of contents?
     */
    public $toc = true;

    /**
     * Default order
     */
    private $defaultOrder = 10;

    /**
     * ID attribute prefix
     */
    public $idPrefix = 'cgit_user_guide_section_';

    /**
     * Page title
     */
    public $title = 'User Guide';

    /**
     * Section separator
     */
    public $separator = '<hr />';

    /**
     * Constructor
     *
     * Private constructor ...
     */
    private function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_menu', [$this, 'addMenu']);
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
     * Add user guide
     */
    public function addMenu()
    {
        add_menu_page(
            'User Guide',
            'User Guide',
            'edit_pages',
            'cgit-user-guide',
            [$this, 'render'],
            'dashicons-editor-help'
        );
    }

    /**
     * Render user guide
     */
    public function render()
    {
        // Filter sections for legacy support
        $this->sections = apply_filters(
            'cgit_user_guide_sections',
            $this->sections
        );

        // Check sections have required keys and sort
        $this->sanitize();
        $this->sort();

        // Sections as compiled HTML
        $sections = [];

        // Table of contents
        if ($this->toc) {
            $sections[] = $this->getToc();
        }

        foreach (array_keys($this->sections) as $key) {
            $sections[] = $this->renderSection($key);
        }

        // Return sections as a single string, separated by $this->separator
        $guide = '<div class="wrap cgit-user-guide">' . '<h2>' . $this->title
            . '</h2>' . implode($this->separator, $sections) . '</div>';

        // Filter guide for legacy support
        $guide = apply_filters('cgit_user_guide', $guide);

        // Print guide
        echo $guide;
    }

    /**
     * Render section content
     */
    private function renderSection($key)
    {
        $section = $this->sections[$key];
        $heading = $section['heading'];
        $content = $section['content'];
        $id = $this->sectionId($key);
        $before = '<h3 id="' . $id . '">' . $heading . '</h3>';

        if (!$heading) {
            $before = '<span id="' . $id . '"></span>';
        }

        $after = '<p class="cgit-user-guide-back">'
                . '<a href="#">Back to top</a></p>';

        return $before . $content . $after;
    }

    /**
     * Get section ID
     */
    private function sectionId($key)
    {
        return $this->idPrefix . $key;
    }

    /**
     * Assemble table of contents
     */
    private function getToc()
    {
        $toc = '<h3>Contents</h3>' . '<ul class="cgit-user-guide-contents">';

        foreach ($this->sections as $key => $section) {
            if ($section['heading']) {
                $toc .= '<li><a href="#' . $this->sectionId($key) . '">'
                    . $section['heading'] . '</a></li>';
            }
        }

        $toc .= '</ul>';

        return $toc;
    }

    /**
     * Enqueue scripts
     */
    public function enqueueScripts($hook)
    {
        if ($hook != 'toplevel_page_cgit-user-guide') {
            return;
        }

        $url = plugin_dir_url(__FILE__);
        $css = $url . '/static/css/style.css';
        $js = $url .'/static/js/common.js';
        $name ='cgit-wp-user-guide';

        wp_enqueue_style($name, $css);
        wp_enqueue_script($name, $js);
    }

    /**
     * Sort sections
     */
    private function sort()
    {
        uasort($this->sections, function($a, $b) {
            return $a['order'] < $b['order'] ? -1 : 1;
        });
    }

    /**
     * Sanitize user guide sections
     *
     * Adds missing keys to each section array and converts legacy sections to
     * the new array format.
     */
    private function sanitize()
    {
        foreach ($this->sections as $key => $section) {

            // Convert legacy strings to the new array format
            if (is_string($section)) {
                $section = [
                    'content' => $section,
                ];
            }

            // Fix missing heading and order values
            $section = $this->setHeading($section);
            $section = $this->setOrder($section, $key);

            $this->sections[$key] = $section;
        }
    }

    /**
     * Find heading in content
     *
     * If the content contains a heading, it is removed from the content so it
     * is not duplicated in the output.
     */
    private function setHeading($section)
    {
        if (isset($section['heading'])) {
            return $section;
        }

        $section['heading'] = '';
        $content = $section['content'];
        $pattern = '/<(h[1-6])[^>]*>(.+?)<\/\1>/i';
        $match = preg_match($pattern, $content, $matches);

        if (isset($matches[2]) && $matches[2]) {
            $section['content'] = preg_replace($pattern, '', $content);
            $section['heading'] = strip_tags($matches[2]);
        }

        return $section;
    }

    /**
     * Set sort order
     *
     * If no order is available, attempt to sort by filter priority. If that is
     * not available, use the default value.
     */
    private function setOrder($section, $key)
    {
        if (isset($section['order'])) {
            return $section;
        }

        global $wp_filter;

        $section['order'] = $this->defaultOrder;
        $name = 'cgit_user_guide_sections';
        $filters = isset($wp_filter[$name]) ? $wp_filter[$name] : [];
        $data = [];

        foreach ($filters as $priority => $filter) {
            foreach ($filter as $item) {
                $function = $item['function'];
                $entries = array_keys($function([]));

                foreach ($entries as $entry) {
                    $data[$entry] = $priority;
                }
            }
        }

        if (array_key_exists($key, $data)) {
            $section['order'] = $data[$key];
        }

        return $section;
    }

    /**
     * Get compiled file output
     *
     * Return the output of a PHP file as a string. This allows a section of the
     * user guide to include some dynamic content.
     */
    public static function getFile($file)
    {
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
