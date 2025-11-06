<?php
// HOME CONTROLLER
// PURPOSE: LOADS HOME PAGE AND SELECTS LAYOUT BASED ON USER ROLE

// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// INCLUDE DEPENDENCIES NEEDED FOR STATE/HELPERS
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';

// READ AUTH STATE (KEEP THIS LIGHTWEIGHT AND ALIGNED TO YOUR SESSION KEYS)
$isLoggedIn = !empty($_SESSION['user_id'] ?? null);
$userType   = $isLoggedIn ? ($_SESSION['user_type'] ?? 'member') : 'guest';

// SET REQUIRED VIEW VARIABLES (MUST HAPPEN BEFORE ANY LAYOUT CONTROLLER THAT VALIDATES)
$pageTitle   = 'Home';
$contentView = __DIR__ . '/../../views/content/home.php'; // adjust if your home view lives elsewhere

// CHOOSE LAYOUT BASED ON USER ROLE AND PERMISSIONS (PRESERVES YOUR EXISTING BEHAVIOUR)
if ($userType === 'admin') {
    // USE ADMIN LAYOUT (VIEW) FOR ADMIN USERS
    $title = $pageTitle . ' - High Street Gym';
    include __DIR__ . '/../../views/layouts/admin.php';
} elseif ($isLoggedIn) {
    // USE MEMBER LAYOUT (VIEW) FOR AUTHENTICATED MEMBERS
    $title = $pageTitle . ' - High Street Gym';
    include __DIR__ . '/../../views/layouts/member.php';
} else {
    // USE PUBLIC LAYOUT CONTROLLER FOR UNAUTHENTICATED USERS
    // (This controller validates $pageTitle and $contentView and renders views/layouts/public.php)
    require __DIR__ . '/../layouts/public_layout.php';
}