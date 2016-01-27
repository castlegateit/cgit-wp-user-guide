<?php

/**
 * Add default user guide sections
 */
$guide = Cgit\UserGuide::getInstance();
$dir = dirname(__FILE__) . '/content';

$guide->addSection('dashboard', [
    'heading' => 'Dashboard',
    'content' => $guide::getFile($dir . '/dashboard.php'),
    'order' => 1,
]);

$guide->addSection('posts', [
    'heading' => 'Posts and pages',
    'content' => $guide::getFile($dir . '/posts.php'),
    'order' => 2,
]);

$guide->addSection('content', [
    'heading' => 'Editing content',
    'content' => $guide::getFile($dir . '/content.php'),
    'order' => 3,
]);
