<?php

/**
 * Old sites
 *
 * Previous versions of the user guide plugin used filters to add and sort user
 * guide sections.
 */
add_filter('cgit_legacy_user_guide_sections', function($sections) {
    $legacy_sections = apply_filters('cgit_user_guide_sections', []);

    foreach ($legacy_sections as $key => $content) {
        $sections[$key] = [
            'content' => $content
        ];
    }

    return $sections;
});

/**
 * Very old sites
 *
 * The user guide was originally a single file placed in the active theme
 * directory.
 */
add_filter('cgit_legacy_user_guide', function($guide) {
    $file = get_stylesheet_directory() . '/user-guide.php';

    if (!file_exists($file)) {
        return $guide;
    }

    return Cgit\UserGuide::getFile($file);
});
