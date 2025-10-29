<?php

// BASE CONTROLLER

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required models
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/session.php';
require_once __DIR__ . '/../models/user_functions.php';  // ✅ ADDED: Include user functions

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

// Get modal error
$modalLoginError = $_SESSION['modal_login_error'] ?? null;
unset($_SESSION['modal_login_error']);

// Prepare flags for login modal
$showModalLoginError = !empty($modalLoginError);
$showLoginModal = $showModalLoginError;

// Login form context for modal
$loginModalContext = [
    'showErrorAlert' => !empty($modalLoginError),
    'errorMessage' => $modalLoginError ?? '',
    'showSuccessAlert' => false,
    'showInfoAlert' => false,
    'infoMessage' => '',
    'successMessageText' => '',
    'showCardWrapper' => false,
    'showRegisterLink' => false,
    'formAction' => '/highstreetgym/controllers/login.php',  // ✅ FIXED: Absolute path
    'previousEmail' => '',
    'redirectUrl' => ''
];

// ACTIVE NAVIGATION HELPER

// Get path for navigation highlighting
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Helper function to determine if navigation item is active
function is_active($needle) {
    global $currentPath;
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

?>