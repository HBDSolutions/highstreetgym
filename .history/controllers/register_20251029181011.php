<?php

// REGISTRATION CONTROLLER

// Include base controller
require_once __DIR__ . '/basecontroller.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'password_confirm' => $_POST['password_confirm'] ?? '',
        'phone' => $_POST['phone'] ?? ''
    ];
    
    // Call model function
    $result = register_user($conn, $data);
    
    if ($result['success']) {
        // Registration successful - redirect to login
        $_SESSION['success_message'] = $result['message'];
        header('Location: /highstreetgym/controllers/login.php');
        exit;
    } else {
        // Registration failed - show errors
        $registrationErrors = $result['errors'] ?? [];
        $registrationMessage = $result['message'] ?? '';
    }
}

// Create registration form context
$registerFormContext = [
    'showErrorAlert' => isset($registrationMessage) && !empty($registrationMessage),
    'errorMessage' => $registrationMessage ?? '',
    'fieldErrors' => $registrationErrors ?? [],
    'showCardWrapper' => true,
    'showLoginLink' => true,
    'formAction' => '/highstreetgym/controllers/register.php',
    'previousData' => [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? ''
    ]
];

// Prepare view variables
$title = 'Register - High Street Gym';
$view = __DIR__ . '/../views/partials/forms/register_form.php';

// Display template
include __DIR__ . '/../views/layouts/base.php';
?>