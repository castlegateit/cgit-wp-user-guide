<?php

/**
 * Very old sites
 *
 * The user guide was originally a single file placed in the active theme
 * directory.
 */
add_filter('cgit_user_guide', function($guide) {
    $file = get_stylesheet_directory() . '/user-guide.php';

    if (!file_exists($file)) {
        return $guide;
    }

    return Cgit\UserGuide::getFile($file);
});
