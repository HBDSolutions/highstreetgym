<?php

// BASE CONTROLLER

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required models
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/session.php';

// USER AUTHENTICATION STATE

// Get user data from session model
$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];
$userName = $currentUser['user_name'];
$userType = $currentUser['user_type'];
$userEmail = $currentUser['user_email'];
$userId = $currentUser['user_id'];

// NAVIGATION FLAGS

// Determine navigation display
$showAdminMenu = $isLoggedIn && $userType === 'admin';
$showMemberMenu = $isLoggedIn;
$showLoginButton = !$isLoggedIn;
$showRegisterButton = !$isLoggedIn;

// LOGIN MODAL SETUP

// Get modal error from session
$modalLoginError = $_SESSION['modal_login_error'] ?? null;
unset($_SESSION['modal_login_error']);

// Prepare flags for login form in modal
$showModalLoginError = !empty($modalLoginError);
$showLoginModal = $showModalLoginError;

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

// Get path for navigation
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Helper function to determine if navigation item is active

function is_active($needle) {
    global $currentPath;
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

?>