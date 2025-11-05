<?php
/**
 * LOGIN CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: User login functionality
 */

// START SESSION IF NOT ALREADY STARTED
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/user_functions.php';

// Get authentication state
$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];

// If already logged in, redirect to home
if ($isLoggedIn) {
    header('Location: /highstreetgym/controllers/content/home_controller.php');
    exit;
}

// Initialise variables
$errors = [];
$errorMessage = '';
$successMessage = '';
$previousEmail = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $redirectUrl = $_POST['redirect'] ?? '/highstreetgym/controllers/content/home_controller.php';
    
    $previousEmail = $email;
    
    if (empty($email) || empty($password)) {
        $errorMessage = 'Please enter both email and password';
    } else {
        $result = login_user($conn, $email, $password);
        
        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['user_email'] = $result['user']['email'];
            $_SESSION['first_name'] = $result['user']['first_name'];
            $_SESSION['last_name'] = $result['user']['last_name'];
            $_SESSION['user_type'] = $result['user']['user_type'];
            $_SESSION['logged_in'] = true;
            
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            $errorMessage = $result['message'] ?? 'Login failed';
        }
    }
}

// Check for success message
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// CONTROLLER DECISIONS - Set flags for what to display
$showErrorAlert = !empty($errorMessage);
$showSuccessAlert = !empty($successMessage);
$showRegisterLink = true;
$formAction = '/highstreetgym/controllers/auth/login_controller.php';

// Define view variables
$pageTitle = 'Login';
$contentView = __DIR__ . '/../../views/auth/login.php';

// Load layout
require_once __DIR__ . '/../layouts/public_layout.php';
?>
