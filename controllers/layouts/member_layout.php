<?php
/**
 * MEMBER LAYOUT CONTROLLER
 * 
 * RESPONSIBILITY: Page-level setup for member-authenticated pages
 * - Database connection
 * - Session management
 * - Enforces authentication (redirects if not logged in)
 * - Global navigation flags
 * 
 * USAGE: Content controllers for member-only pages include this file
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database and session models
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';

// Get current user state
$currentUser = get_current_user_display();

// PAGE ACCESS PERMISSION: Must be logged in
if (!$currentUser['is_logged_in']) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: /highstreetgym/index.php');
    exit;
}

// Make authentication state available globally
$isLoggedIn = true; // Always true for this layout
$userId = $currentUser['user_id'];
$userName = $currentUser['user_name'];
$userEmail = $currentUser['user_email'];
$userType = $currentUser['user_type'];

// Navigation flags for member layout
$showAdminMenu = ($userType === 'admin');
$showMemberMenu = true;
$showLoginButton = false;

// Navigation helper function
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

function is_active($needle) {
    global $currentPath;
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

// Validate required variables from content controller
if (!isset($pageTitle)) {
    die('Error: Content controller must define $pageTitle');
}

if (!isset($contentView)) {
    die('Error: Content controller must define $contentView');
}

// Set page title for title tag
$title = $pageTitle . ' - High Street Gym';

// Render the member layout
include __DIR__ . '/../../views/layouts/member.php';
?>