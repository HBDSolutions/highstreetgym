<?php
// ADMIN LAYOUT CONTROLLER

declare(strict_types=1);

// START SESSION
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// INCLUDE BASE LAYOUT AND HELPERS
require_once __DIR__ . '/base_layout.php';
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/navigation.php';

// AUTH SNAPSHOT
$currentUser = get_current_user_display();
$isLoggedIn  = (bool)$currentUser['is_logged_in'];
$isAdmin     = ($currentUser['user_type'] ?? '') === 'admin';

// NAV VARS (ADMIN)
$navVars = [
  'currentUser'    => $currentUser,
  'isLoggedIn'     => $isLoggedIn,
  'isAdmin'        => $isAdmin,
  'showMemberMenu' => false,
  'showAdminMenu'  => $isAdmin,
  'currentPath'    => parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/',
];

// REQUIRE VIEW VARS FROM CALLER
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// RENDER VIEW
include __DIR__ . '/../../views/layouts/admin.php';