<?php
// ADMIN LAYOUT CONTROLLER

declare(strict_types=1);

// START SESSION
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// INCLUDE BASE LAYOUT UTILITIES
require_once __DIR__ . '/base_layout.php';

// AUTH SNAPSHOT
$currentUser = get_current_user_display();
$isLoggedIn  = (bool)$currentUser['is_logged_in'];
$isAdmin     = ($currentUser['user_type'] ?? '') === 'admin';

// NAV VARS
$navVars = [
  'currentUser'    => $currentUser,
  'isLoggedIn'     => $isLoggedIn,
  'isAdmin'        => $isAdmin,
  'showMemberMenu' => $isLoggedIn && !$isAdmin,
  'showAdminMenu'  => $isAdmin,
  'currentPath'    => parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/',
];

// REQUIRE VIEW VARS FROM CALLER
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// PASS TO VIEW
include __DIR__ . '/../../views/layouts/admin.php';