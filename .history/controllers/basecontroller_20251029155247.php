<?php

// BASE CONTROLLER

// Start session if not already

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required models
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/session.php';

// Prepare authentication state for all views

$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];
$userName = $currentUser['user_name'];
$userType = $currentUser['user_type'];
$userEmail = $currentUser['user_email'];
$userId = $currentUser['user_id'];

?>