<?php
/**
 * LOGOUT CONTROLLER
 * 
 * RESPONSIBILITY: User logout functionality
 * - Destroys user session
 * - Clears authentication data
 * - Redirects to home page
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy all session data
session_destroy();

// Clear session variables
$_SESSION = [];

// Redirect to home page
header('Location: /highstreetgym/controllers/content/home_controller.php');
exit;
?>