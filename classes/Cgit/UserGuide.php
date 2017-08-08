<?php

namespace Cgit;

/**
 * Legacy user guide class for backward compatibility
 *
 * @deprecated 5.0
 */
class UserGuide
{
    /**
     * Return compiled file output
     *
     * Return the output of a PHP file as a string. From version 5.0, this is
     * simply a wrapper around the more sophisticated Content class.
     *
     * @deprecated 5.0
     * @param string $file
     * @return string
     */
    public static function getFile($file)
    {
        return \Cgit\UserGuide\Content::load($file);
    }
}
