<?php
// PUBLIC LAYOUT CONTROLLER

if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once __DIR__ . '/base_layout.php';

$ctx = init_base_layout();

// NAV DATA FOR VIEWS
$navData = function_exists('get_navigation_data')
    ? get_navigation_data($ctx['currentPath'] ?? '/', $ctx['isLoggedIn'] ?? false, $ctx['userType'] ?? 'guest')
    : [];

// VALIDATE REQUIRED VARS
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// PAGE TITLE
$title = ($pageTitle ?? 'High Street Gym') . ' - High Street Gym';

// RENDER
include __DIR__ . '/../../views/layouts/public.php';
