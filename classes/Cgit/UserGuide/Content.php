<?php

namespace Cgit\UserGuide;

/**
 * User guide section content
 *
 * Load and, if necessary, parse content from separate source files for use in
 * user guide sections. This could be used by other plugins.
 */
class Content
{
    /**
     * Path to content file
     *
     * @var string
     */
    private $path;

    /**
     * Raw content
     *
     * @var string
     */
    private $content;

    /**
     * File type based on extension
     *
     * @var string
     */
    private $type;

    /**
     * Known file extensions and their corresponding parser methods
     *
     * @var array
     */
    private $knownTypes = [
        'markdown' => 'parseMarkdown',
        'md' => 'parseMarkdown',
        'mdown' => 'parseMarkdown',
        'php' => 'parsePhp',
    ];

    /**
     * Constructor
     *
     * Determine the file type based on its extension, check that the file
     * exists, and load its content.
     *
     * @param string $path
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->type = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (!file_exists($path)) {
            return trigger_error('Missing file: ' . $path);
        }

        $this->content = file_get_contents($path);
    }

    /**
     * Parse content according to its type
     *
     * If the file type is something we can process here, parse it and return
     * the result. Otherwise, return the content unmodified.
     *
     * @return string
     */
    public function parse()
    {
        if (array_key_exists($this->type, $this->knownTypes)) {
            $method = $this->knownTypes[$this->type];

            if (method_exists($this, $method)) {
                return $this->$method();
            }
        }

        return $this->content;
    }

    /**
     * Parse content as PHP
     *
     * @return string
     */
    private function parsePhp()
    {
        ob_start();
        include $this->path;
        return ob_get_clean();
    }

    /**
     * Parse content as Markdown
     *
     * @return string
     */
    private function parseMarkdown()
    {
        return (new \Parsedown)->text($this->content);
    }

    /**
     * Static content loader
     *
     * @return string
     */
    public static function load($path)
    {
        return (new self($path))->parse();
    }
}
