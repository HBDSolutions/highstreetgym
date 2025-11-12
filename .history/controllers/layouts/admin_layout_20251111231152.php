<?php
// ADMIN LAYOUT CONTROLLER

// INCLUDE BASE LAYOUT AND HELPERS
require_once __DIR__ . '/base_layout.php';

// SIMPLE RBAC CHECK (EXPECTS MODELS/SESSION)
if (($boot['currentUser']['user_type'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('FORBIDDEN: ADMIN ONLY');
}

$pageTitle   = $pageTitle   ?? 'Admin Home';
$contentView = $contentView ?? (__DIR__ . '/../../views/admin/dashboard.php');

// ADMIN DEFAULTS (LOGGED IN, ADMIN)
$navVars = [
    'currentUser'    => $boot['currentUser'],
    'isLoggedIn'     => true,
    'isAdmin'        => true,
    'showMemberMenu' => false,
    'showAdminMenu'  => true,
    'currentPath'    => $boot['currentPath'],
];

// REQUIRE VIEW VARS FROM CALLER
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// RENDER VIEW
include __DIR__ . '/../../views/layouts/admin.php';