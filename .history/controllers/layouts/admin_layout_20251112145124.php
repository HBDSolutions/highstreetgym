<?php
// ADMIN LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT AND HELPERS
require_once __DIR__ . '/base_layout.php';

$title = isset($pageTitle) ? ($pageTitle . ' - High Street Gym') : 'High Street Gym';
if (!isset($contentView)) {
    $contentView = __DIR__ . '/../../views/admin/dashboard.php';
}

validate_layout_requirements($title, $contentView);

require __DIR__ . '/../../views/layouts/admin.php';