<?php
/**
 * PUBLIC LAYOUT CONTROLLER
 * 
 * RESPONSIBILITY: Page-level setup for public (unauthenticated) pages
 */

// Include base layout functionality
require_once __DIR__ . '/base_layout.php';

// Initialise and get all base data
$layoutData = init_base_layout();

// Extract layout data into local variables
$currentUser = $layoutData['currentUser'];
$isLoggedIn = $layoutData['isLoggedIn'];
$userId = $layoutData['userId'];
$userName = $layoutData['userName'];
$userEmail = $layoutData['userEmail'];
$userType = $layoutData['userType'];
$currentPath = $layoutData['currentPath'];
$showLoginModal = $layoutData['showLoginModal'];
$loginModalContext = $layoutData['loginModalContext'];

// Navigation flags for public layout
$showAdminMenu = $isLoggedIn && ($userType === 'admin');
$showMemberMenu = $isLoggedIn;
$showLoginButton = !$isLoggedIn;

// Validate required variables from content controller
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

// Set page title for <title> tag
$title = $pageTitle . ' - High Street Gym';

// Render the public layout
include __DIR__ . '/../../views/layouts/public.php';
?>