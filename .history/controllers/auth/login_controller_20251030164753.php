<?php
/**
 * LOGIN CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: User login functionality
 * - Handles login form submission
 * - Validates credentials
 * - Manages session creation
 * - Uses public_layout for rendering
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../../../models/database.php';
require_once __DIR__ . '/../../../models/session.php';
require_once __DIR__ . '/../../../models/user_functions.php';

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
$loginError = '';
$showError = false;
$previousEmail = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $redirectUrl = $_POST['redirect'] ?? '/highstreetgym/controllers/content/home_controller.php';
    
    $previousEmail = $email; // Remember email for form repopulation
    
    // Basic validation
    if (empty($email) || empty($password)) {
        $loginError = 'Please enter both email and password';
        $showError = true;
    } else {
        // Call BUSINESS LOGIC in model
        $result = login_user($conn, $email, $password);
        
        if ($result['success']) {
            // Login successful - set session variables
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['user_email'] = $result['user']['email'];
            $_SESSION['first_name'] = $result['user']['first_name'];
            $_SESSION['last_name'] = $result['user']['last_name'];
            $_SESSION['user_type'] = $result['user']['user_type'];
            $_SESSION['logged_in'] = true;
            
            // Redirect to intended page or home
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            // Login failed
            $loginError = $result['message'] ?? 'Login failed';
            $showError = true;
        }
    }
}

// Check for success message (e.g., after registration)
$successMessage = $_SESSION['success_message'] ?? '';
$showSuccess = !empty($successMessage);
if ($showSuccess) {
    unset($_SESSION['success_message']);
}

// Define view context variables
$showErrorAlert = $showError;
$errorMessage = $loginError;
$showSuccessAlert = $showSuccess;
$successMessageText = $successMessage;
$showCardWrapper = true;
$showRegisterLink = true;
$formAction = '/highstreetgym/controllers/content/auth/login_controller.php';

// Define required view variables for layout controller
$pageTitle = 'Login';
$contentView = __DIR__ . '/../../../views/content/auth/login.php';

// Load layout controller (handles rendering)
require_once __DIR__ . '/../../layouts/public_layout.php';
?>