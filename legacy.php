<?php

/**
 * Old sites
 *
 * Previous versions of the user guide plugin used filters to add and sort user
 * guide sections. These sections did not have headings.
 */
add_filter('cgit_legacy_user_guide_sections', function($sections) {
    global $wp_filter;

    // We want to preserve the order of the sections, which was set using the
    // filter priority in previous versions. Therefore, we cannot simply use
    // apply_filters() here.
    $filter_name = 'cgit_user_guide_sections';
    $filters = $wp_filter[$filter_name];

    foreach ($filters as $priority => $filter) {
        foreach ($filter as $item) {
            $function = $item['function'];
            $legacy_sections = $function([]);

            foreach ($legacy_sections as $key => $content) {
                $sections[$key] = [
                    'content' => $content,
                    'order' => $priority,
                ];
            }
        }
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
