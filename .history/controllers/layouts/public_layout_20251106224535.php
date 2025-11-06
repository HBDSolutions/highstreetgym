<?php
// PUBLIC LAYOUT CONTROLLER
// PURPOSE: VALIDATES REQUIRED VARS AND RENDERS PUBLIC LAYOUT VIEW

// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// INCLUDE BASE LAYOUT UTILITIES
require_once __DIR__ . '/base_layout.php';
require_once __DIR__ . '/../../models/navigation.php';

// VALIDATE REQUIRED VIEW VARIABLES
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// SET PAGE TITLE FOR <title>
$title = ($pageTitle ?? 'High Street Gym');

// RENDER LAYOUT VIEW (NO HTML HERE)
include __DIR__ . '/../../views/layouts/public.php';
