<?php
// MEMBER LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT
require_once __DIR__ . '/base_layout.php';

$boot = init_base_layout();
$pageTitle   = $pageTitle   ?? 'Member';
$contentView = $contentView ?? (__DIR__ . '/../../views/content/home.php');

// AUTH SNAPSHOT
$currentUser = get_current_user_display();
$isLoggedIn  = (bool)$currentUser['is_logged_in'];
$isAdmin     = ($currentUser['user_type'] ?? '') === 'admin';

// NAV VARS FOR MEMBER LAYOUT
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

// RENDER VIEW
include __DIR__ . '/../../views/layouts/member.php';