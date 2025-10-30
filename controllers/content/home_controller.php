<?php
/**
 * HOME CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Home page content and data
 * - Displays welcome message
 * - Shows featured classes or promotions
 * - Uses public_layout for rendering
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
$userEmail = $currentUser['user_email'];
$userType = $currentUser['user_type'];

// Initialise view variables
$welcomeMessage = $isLoggedIn 
    ? "Welcome back, " . htmlspecialchars($userName) . "!" 
    : "Welcome to High Street Gym!";

// Define required view variables for layout controller
$pageTitle = 'Home';
$contentView = __DIR__ . '/../../views/content/home.php';

// Load layout controller (handles rendering)
require_once __DIR__ . '/../layouts/public_layout.php';
?>