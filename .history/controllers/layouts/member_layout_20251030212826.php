<?php
/**
 * MEMBER LAYOUT CONTROLLER
 * 
 * RESPONSIBILITY: Page-level setup for member-authenticated pages
 */

// Include base layout functionality
require_once __DIR__ . '/base_layout.php';

// Initialise and get all base data
$layoutData = init_base_layout();

// Extract authentication data
$currentUser = $layoutData['currentUser'];
$isLoggedIn = $layoutData['isLoggedIn'];

// PAGE ACCESS PERMISSION: Must be logged in
if (!$isLoggedIn) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: /highstreetgym/index.php');
    exit;
}

// Extract remaining layout data
$userId = $layoutData['userId'];
$userName = $layoutData['userName'];
$userEmail = $layoutData['userEmail'];
$userType = $layoutData['userType'];
$currentPath = $layoutData['currentPath'];

// Navigation flags for member layout
$showAdminMenu = ($userType === 'admin');
$showMemberMenu = true;
$showLoginButton = false;

// Validate required variables from content controller
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// Set page title for <title> tag
$title = $pageTitle . ' - High Street Gym';

// Render the member layout
include __DIR__ . '/../../views/layouts/member.php';
?>