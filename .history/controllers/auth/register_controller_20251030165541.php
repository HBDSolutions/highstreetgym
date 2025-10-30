<?php
/**
 * REGISTER CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: User registration functionality
 * - Handles registration form submission
 * - Validates user data
 * - Creates new user account
 * - Uses public_layout for rendering
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
$userId = $currentUser['user_id'];
$userName = $currentUser['user_name'];
$userEmail = $currentUser['user_email'];
$userType = $currentUser['user_type'];

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
    // Get form data
    $formData = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'password_confirm' => $_POST['password_confirm'] ?? '',
        'phone' => trim($_POST['phone'] ?? '')
    ];
    
    // Call BUSINESS LOGIC in model
    $result = register_user($conn, $formData);
    
    if ($result['success']) {
        // Registration successful - redirect to login
        $_SESSION['success_message'] = $result['message'];
        header('Location: /highstreetgym/controllers/auth/login_controller.php');
        exit;
    } else {
        // Registration failed - show errors
        $errors = $result['errors'] ?? [];
    }
}

// Define required view variables for layout controller
$pageTitle = 'Register';
$contentView = __DIR__ . '/../../views/auth/register.php';

// Load layout controller (handles rendering)
require_once __DIR__ . '/../layouts/public_layout.php';
?>