<?php
// PUBLIC LAYOUT CONTROLLER

declare(strict_types=1);

require_once __DIR__ . '/base_layout.php';

// INIT LAYOUT STATE (IF YOU NEED FLAGS IN SCOPE)
$state = init_base_layout();
extract($state, EXTR_SKIP);

// MAP CONTROLLER VARS TO LAYOUT VIEW VARS
// EXPECTS: $pageTitle and $contentView set by the content controller
$title = isset($pageTitle) ? ($pageTitle . ' - High Street Gym') : 'High Street Gym';
if (!isset($contentView)) {
    // SAFE FALLBACK ONLY (SHOULD BE SET BY CONTENT CONTROLLER)
    $contentView = __DIR__ . '/../../views/content/home.php';
}

// VALIDATE INPUTS FOR BASE VIEW
validate_layout_requirements($title, $contentView);

// RENDER LAYOUT VIEW
require __DIR__ . '/../../views/layouts/public.php';
