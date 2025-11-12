<?php
// MEMBER LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT
require_once __DIR__ . '/base_layout.php';

$title = isset($pageTitle) ? ($pageTitle . ' - High Street Gym') : 'High Street Gym';
if (!isset($contentView)) {
    $contentView = __DIR__ . '/../../views/content/home.php';
}

validate_layout_requirements($title, $contentView);

require __DIR__ . '/../../views/layouts/member.php';