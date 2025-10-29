<?php

// LOGIN CONTROLLER

// Include base controller
require_once __DIR__ . '/basecontroller.php';

// Include page-specific models
require_once __DIR__ . '/../models/user_functions.php';

// Process login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $redirect = $_POST['redirect'] ?? 'index.php';
    
    // Call model function for authentication
    $result = login_user($conn, $email, $password);
    
    if ($result['success']) {
        // Set session variables
        $_SESSION['user_id'] = $result['user']['user_id'];
        $_SESSION['user_email'] = $result['user']['email'];
        $_SESSION['user_name'] = $result['user']['first_name'] . ' ' . $result['user']['last_name'];
        $_SESSION['user_type'] = $result['user']['user_type'];
        $_SESSION['logged_in'] = true;
        
        // Redirect to destination
        header('Location: ../' . $redirect);
        exit;
    } else {
        // Store error for display
        $loginError = $result['message'];
    }
}

// Get session messages
$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

// Prepare flags
$showErrorAlert = isset($loginError) && !empty($loginError);
$showSuccessAlert = isset($successMessage) && !empty($successMessage);
$showCardWrapper = true;
$showRegisterLink = true;

// Prepare data for view
$errorMessage = $loginError ?? '';
$successMessageText = $successMessage ?? '';
$formAction = 'controllers/login.php';
$previousEmail = $_POST['email'] ?? '';
$redirectUrl = $_GET['redirect'] ?? '';

// Get info message
$infoMessage = '';
$showInfoAlert = false;
if (isset($_GET['msg'])) {
    $showInfoAlert = true;
    switch ($_GET['msg']) {
        case 'session_expired':
            $infoMessage = 'Your session has expired. Please login again.';
            break;
        case 'login_required':
            $infoMessage = 'Please login to access this page.';
            break;
        default:
            $showInfoAlert = false;
    }
}

// Prepare view
$title = 'Login - High Street Gym';
$view = __DIR__ . '/../views/partials/forms/login_form.php';

// Load template
include __DIR__ . '/../views/layouts/base.php';
?>