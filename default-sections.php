<?php

/**
 * Add default user guide sections
 */
add_filter('cgit_user_guide_sections', function($sections) {
    $dirname = dirname(__FILE__) . '/content/';

    $sections['dashboard'] = [
        'heading' => 'Dashboard',
        'content' => Cgit\UserGuide::getFile($dirname . '/dashboard.php'),
        'order' => 1,
    ];

    $sections['posts'] = [
        'heading' => 'Posts and pages',
        'content' => Cgit\UserGuide::getFile($dirname . '/posts.php'),
        'order' => 2,
    ];

    $sections['content'] = [
        'heading' => 'Editing content',
        'content' => Cgit\UserGuide::getFile($dirname . '/content.php'),
        'order' => 3,
    ];

    return $sections;
}, 5);
