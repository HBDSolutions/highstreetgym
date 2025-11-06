<?php
// PUBLIC LAYOUT CONTROLLER
// PURPOSE: VALIDATES REQUIRED VARS AND RENDERS PUBLIC LAYOUT VIEW

if (session_status() === PHP_SESSION_NONE) { session_start(); }

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/base_layout.php';

validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

$title = ($pageTitle ?? 'High Street Gym');

include __DIR__ . '/../../views/layouts/public.php';
