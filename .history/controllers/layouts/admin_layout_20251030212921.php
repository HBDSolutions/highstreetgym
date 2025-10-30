<?php
/**
 * ADMIN LAYOUT CONTROLLER
 * 
 * RESPONSIBILITY: Page-level setup for admin-only pages
 */

// Include base layout functionality
require_once __DIR__ . '/base_layout.php';

// Initialise and get all base data
$layoutData = init_base_layout();

// Extract authentication data
$currentUser = $layoutData['currentUser'];
$isLoggedIn = $layoutData['isLoggedIn'];

// PAGE ACCESS PERMISSION: Must be logged in as admin
if (!$isLoggedIn) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: /highstreetgym/index.php');
    exit;
}

if ($currentUser['user_type'] !== 'admin') {
    // Logged in but not admin - access denied
    $_SESSION['error_message'] = 'Access denied. Admin privileges required.';
    header('Location: /highstreetgym/index.php');
    exit;
}

// Extract remaining layout data
$userId = $layoutData['userId'];
$userName = $layoutData['userName'];
$userEmail = $layoutData['userEmail'];
$userType = 'admin'; // Always admin for this layout
$currentPath = $layoutData['currentPath'];

// Navigation flags for admin layout
$showAdminMenu = true;
$showMemberMenu = true;
$showLoginButton = false;

// Validate required variables from content controller
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// Set page title for <title> tag
$title = $pageTitle . ' - Admin - High Street Gym';

// Render the admin layout
include __DIR__ . '/../../views/layouts/admin.php';
?>