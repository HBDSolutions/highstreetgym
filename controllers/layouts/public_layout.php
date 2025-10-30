<?php
// Public Layout Controller
// This controller is responsible for the page-level setup for public unauthenticated pages.

// Start the session
session_start();

// Include database connection
require_once 'models/database.php';

// Include session management
require_once 'models/session.php';

// Get current user state (may be guest)
$currentUser = getCurrentUser();

// Set authentication variables
$isLoggedIn = isset($currentUser);
$userId = $isLoggedIn ? $currentUser['id'] : null;
$userName = $isLoggedIn ? $currentUser['name'] : null;
$userEmail = $isLoggedIn ? $currentUser['email'] : null;
$userType = $isLoggedIn ? $currentUser['type'] : 'guest';

// Set navigation flags
$showAdminMenu = ($userType === 'admin');
$showMemberMenu = ($userType === 'member');
$showLoginButton = !$isLoggedIn;

// Setup login modal with error handling
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle login logic
    $error = handleLogin($_POST);
}

// Navigation helper function to check active state
function is_active($page) {
    return (basename($_SERVER['PHP_SELF']) === $page) ? 'active' : '';
}

// Validate that pageTitle and contentView are set by content controller
if (!isset($pageTitle) || !isset($contentView)) {
    die('Error: pageTitle and contentView must be set.');
}

// Set title variable for page title tag
$title = htmlspecialchars($pageTitle);

// Include the public layout view
include 'views/layouts/public.php';
?>