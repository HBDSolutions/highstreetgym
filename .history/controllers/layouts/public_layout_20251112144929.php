<?php
// PUBLIC LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT
require_once __DIR__ . '/base_layout.php';

// MAP CONTROLLER VARS TO LAYOUT VIEW VARS
$title = isset($pageTitle) ? ($pageTitle . ' - High Street Gym') : 'High Street Gym';
if (!isset($contentView)) {
    $contentView = __DIR__ . '/../../views/content/home.php';
}

// VALIDATE INPUTS FOR BASE VIEW
validate_layout_requirements($title, $contentView);

// RENDER LAYOUT VIEW
require __DIR__ . '/../../views/layouts/public.php';