<?php
// PUBLIC LAYOUT CONTROLLER
// PURPOSE: VALIDATES REQUIRED VARS AND RENDERS PUBLIC LAYOUT VIEW

// START SESSION
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// INCLUDE BASE UTILITIES
require_once __DIR__ . '/base_layout.php';

// VALIDATE REQUIRED VARS
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// PAGE TITLE FOR <title>
$title = ($pageTitle ?? 'High Street Gym');

// RENDER LAYOUT VIEW
include __DIR__ . '/../../views/layouts/public.php';
