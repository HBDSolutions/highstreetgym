<?php

// BASE CONTROLLER
// Sets up common variables for ALL views
// Include this at the top of every page controller

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/user_functions.php';

// SESSION & USER STATE

// Get user authentication state
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userType = $_SESSION['user_type'] ?? null;
$userName = $_SESSION['user_name'] ?? 'Guest';
$userId = $_SESSION['user_id'] ?? null;

// NAVIGATION FLAGS

// Determine what to show in navigation
$showAdminMenu = $isLoggedIn && $userType === 'admin';
$showMemberMenu = $isLoggedIn;
$showLoginButton = !$isLoggedIn;
$showRegisterButton = !$isLoggedIn;

// LOGIN MODAL SETUP

// Get modal-specific error from session
$modalLoginError = $_SESSION['modal_login_error'] ?? null;
unset($_SESSION['modal_login_error']);

// Prepare flags for login form in modal
$showModalLoginError = !empty($modalLoginError);
$showLoginModal = $showModalLoginError; // Auto-show modal if error exists

// Login form configuration for modal
$loginModal_showErrorAlert = !empty($modalLoginError);
$loginModal_errorMessage = $modalLoginError ?? '';
$loginModal_showSuccessAlert = false;
$loginModal_showInfoAlert = false;
$loginModal_infoMessage = '';
$loginModal_successMessageText = '';
$loginModal_showCardWrapper = false;
$loginModal_showRegisterLink = false;
$loginModal_formAction = 'controllers/authcontroller.php';
$loginModal_previousEmail = '';
$loginModal_redirectUrl = '';

// ACTIVE NAVIGATION HELPER

// Get current path for navigation highlighting
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

/**
 * Helper function to determine if navigation item is active
 * @param string $needle The path to check
 * @return string 'active' or empty string
 */
function is_active($needle) {
    global $currentPath;
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

// COMMON VIEW VARIABLES

// Page title
$pageTitle = $pageTitle ?? 'High Street Gym';

?>