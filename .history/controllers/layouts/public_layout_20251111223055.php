<?php
// PUBLIC LAYOUT CONTROLLER

declare(strict_types=1);

// START SESSION
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// INCLUDE BASE LAYOUT AND HELPERS
require_once __DIR__ . '/base_layout.php';
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/navigation.php';

// PUBLIC DEFAULTS
$currentUser = [
  'is_logged_in' => false,
  'user_id'      => 0,
  'user_name'    => '',
  'user_type'    => 'guest',
];

// NAV VARS FOR PUBLIC USERS
$navVars = [
  'currentUser'    => $currentUser,
  'isLoggedIn'     => false,
  'isAdmin'        => false,
  'showMemberMenu' => false,
  'showAdminMenu'  => false,
  'currentPath'    => parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/',
];

// REQUIRE VIEW VARS FROM CALLER
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// RENDER VIEW
include __DIR__ . '/../../views/layouts/public.php';