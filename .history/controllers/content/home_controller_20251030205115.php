<?php
/**
 * HOME CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Home page content and data
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';

// Get authentication state
$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];
$userId = $currentUser['user_id'];
$userName = $currentUser['user_name'];
$userType = $currentUser['user_type'];

// Prepare welcome message
$welcomeMessage = $isLoggedIn 
    ? "Welcome back, " . htmlspecialchars($userName) . "!" 
    : "Welcome to High Street Gym!";

// CONTROLLER DECISIONS - Set flags for what to display
$showMemberButtons = $isLoggedIn;
$showGuestButtons = !$isLoggedIn;

// Define view variables
$pageTitle = 'Home';
$contentView = __DIR__ . '/../../views/content/home.php';

// Load layout
require_once __DIR__ . '/../layouts/public_layout.php';
?>