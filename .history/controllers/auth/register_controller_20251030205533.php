<?php
/**
 * REGISTER CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: User registration functionality
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
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
$formData = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone' => ''
];

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'password_confirm' => $_POST['password_confirm'] ?? '',
        'phone' => trim($_POST['phone'] ?? '')
    ];
    
    $result = register_user($conn, $formData);
    
    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
        header('Location: /highstreetgym/controllers/auth/login_controller.php');
        exit;
    } else {
        $errors = $result['errors'] ?? [];
    }
}

// CONTROLLER DECISIONS - Set flags for what to display
$showErrors = !empty($errors);

// Define view variables
$pageTitle = 'Register';
$contentView = __DIR__ . '/../../views/auth/register.php';

// Load layout
require_once __DIR__ . '/../layouts/public_layout.php';
?>