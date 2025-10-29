<?php

// LOGIN CONTROLLER

// Include base controller
require_once __DIR__ . '/basecontroller.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $redirect = $_POST['redirect'] ?? 'index.php';
    
    // Call login function
    $result = login_user($conn, $email, $password);
    
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user']['user_id'];
        $_SESSION['user_email'] = $result['user']['email'];
        $_SESSION['user_name'] = $result['user']['first_name'] . ' ' . $result['user']['last_name'];
        $_SESSION['user_type'] = $result['user']['user_type'];
        $_SESSION['logged_in'] = true;
        
        // Redirect after successful login
        header('Location: ../' . $redirect);
        exit;
    } else {
        // Display error message
        $loginError = $result['message'];
    }
}

// Get session messages
$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

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

// Create login form context

$loginFormContext = [
    'showErrorAlert' => isset($loginError) && !empty($loginError),
    'errorMessage' => $loginError ?? '',
    'showSuccessAlert' => isset($successMessage) && !empty($successMessage),
    'successMessageText' => $successMessage ?? '',
    'showInfoAlert' => $showInfoAlert,
    'infoMessage' => $infoMessage,
    'showCardWrapper' => true,
    'showRegisterLink' => true,
    'formAction' => 'controllers/authcontroller.php',
    'previousEmail' => $_POST['email'] ?? '',
    'redirectUrl' => $_GET['redirect'] ?? ''
];

// Prepare view variables
$title = 'Login - High Street Gym';
$view = __DIR__ . '/../views/partials/forms/login_form.php';

// Display template
include __DIR__ . '/../views/layouts/base.php';
?>