<?php
// ADMIN LAYOUT CONTROLLER
// PURPOSE: PAGE-LEVEL SETUP FOR ADMIN-ONLY PAGES

// INCLUDE DEPENDENCIES
require_once __DIR__ . '/base_layout.php';


// INITIALISE BASE LAYOUT DATA
$layoutData = init_base_layout();

// ENFORCE ADMIN ACCESS
$currentUser = $layoutData['currentUser'];
$isLoggedIn  = $layoutData['isLoggedIn'];

if (!$isLoggedIn) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '/';
    header('Location: /highstreetgym/index.php');
    exit;
}

if (($currentUser['user_type'] ?? null) !== 'admin') {
    $_SESSION['error_message'] = 'Access denied. Admin privileges required.';
    header('Location: /highstreetgym/index.php');
    exit;
}

// EXTRACT LAYOUT VARIABLES
$userId      = $layoutData['userId'];
$userName    = $layoutData['userName'];
$userEmail   = $layoutData['userEmail'];
$userType    = 'admin';
$currentPath = $layoutData['currentPath'];

// NAVIGATION FLAGS
$showAdminMenu   = true;
$showMemberMenu  = true;
$showLoginButton = false;

// VALIDATE REQUIRED VIEW VARIABLES
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// SET PAGE TITLE
$title = ($pageTitle ?? 'Admin') . ' - Admin - High Street Gym';

// RENDER ADMIN LAYOUT VIEW
include __DIR__ . '/../../views/layouts/admin.php';
?>