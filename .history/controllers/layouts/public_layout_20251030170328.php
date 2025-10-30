<?php
/**
 * PUBLIC LAYOUT CONTROLLER
 * 
 * RESPONSIBILITY: Page-level setup for public (unauthenticated) pages
 * - Database connection
 * - Session management  
 * - Authentication state (allows guests)
 * - Global navigation flags
 * 
 * USAGE: Content controllers include this file and it renders the layout
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database and session models
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';

// Get current user state (may be guest)
$currentUser = get_current_user_display();

// Make authentication state available globally
$isLoggedIn = $currentUser['is_logged_in'];
$userId = $currentUser['user_id'];
$userName = $currentUser['user_name'];
$userEmail = $currentUser['user_email'];
$userType = $currentUser['user_type'];

// Navigation flags for public layout
$showAdminMenu = $isLoggedIn && ($userType === 'admin');
$showMemberMenu = $isLoggedIn;
$showLoginButton = !$isLoggedIn;

// Login modal setup
$modalLoginError = $_SESSION['modal_login_error'] ?? null;
unset($_SESSION['modal_login_error']);

$showModalLoginError = !empty($modalLoginError);
$showLoginModal = $showModalLoginError;

$loginModalContext = [
    'showErrorAlert' => $showModalLoginError,
    'errorMessage' => $modalLoginError ?? '',
    'formAction' => '/highstreetgym/controllers/auth/login_controller.php'
];

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

// Render the public layout
include __DIR__ . '/../../views/layouts/public.php';
?>