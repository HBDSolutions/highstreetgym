<?php
// MEMBER LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT
require_once __DIR__ . '/base_layout.php';

$boot = init_base_layout();
$pageTitle   = $pageTitle   ?? 'Member';
$contentView = $contentView ?? (__DIR__ . '/../../views/content/home.php');

// MEMBER DEFAULTS (LOGGED IN, NOT ADMIN)
$navVars = [
    'currentUser'    => $boot['currentUser'],
    'isLoggedIn'     => true,
    'isAdmin'        => false,
    'showMemberMenu' => true,
    'showAdminMenu'  => false,
    'currentPath'    => $boot['currentPath'],
];

// REQUIRE VIEW VARS FROM CALLER
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// RENDER VIEW
include __DIR__ . '/../../views/layouts/member.php';