<?php
// PUBLIC LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT
require_once __DIR__ . '/base_layout.php';

// PUBLIC DEFAULTS (LOGGED OUT)
$navVars = [
    'currentUser'    => ['currentUser'],
    'isLoggedIn'     => false,
    'isAdmin'        => false,
    'showMemberMenu' => false,
    'showAdminMenu'  => false,
    'currentPath'    => ['currentPath'],
];

// REQUIRE VIEW VARS FROM CALLER
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// RENDER VIEW
include __DIR__ . '/../../views/layouts/public.php';