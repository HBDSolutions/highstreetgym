<?php
declare(strict_types=1);

// REGISTER CONTROLLER

// SHOW FORM
function show_register_form(): void {
    // START SESSION FOR LAYOUT
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // INCLUDE DEPENDENCIES
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/session.php';

    // GET AUTHENTICATION STATE
    $currentUser = get_current_user_display();
    $isLoggedIn = $currentUser['is_logged_in'];
    $userId = $currentUser['user_id'];
    $userName = $currentUser['user_name'];
    $userType = $currentUser['user_type'];

    // DEFINE VIEW VARIABLES
    $pageTitle = 'Register';
    $contentView = __DIR__ . '/../../views/auth/register.php';

    // LOAD LAYOUT
    require_once __DIR__ . '/../layouts/public_layout.php';
}

// HANDLE POST
function handle_register(): void {
    session_start();

    $first = trim((string)($_POST['first_name'] ?? ''));
    $last  = trim((string)($_POST['last_name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $pass  = (string)($_POST['password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    if ($first === '' || $last === '' || $email === '' || $pass === '') {
        $_SESSION['flash_error'] = 'ALL FIELDS ARE REQUIRED.';
        header('Location: /highstreetgym/controllers/auth/register_controller.php');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_error'] = 'INVALID EMAIL ADDRESS.';
        header('Location: /highstreetgym/controllers/auth/register_controller.php');
        exit;
    }
    if ($pass !== $confirm) {
        $_SESSION['flash_error'] = 'PASSWORDS DO NOT MATCH.';
        header('Location: /highstreetgym/controllers/auth/register_controller.php');
        exit;
    }

    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/user_functions.php';

    // CREATE USER USING THE AVAILABLE REGISTER_USER FUNCTION
    $conn = get_database_connection();
    $registrationData = [
        'first_name' => $first,
        'last_name' => $last,
        'email' => $email,
        'password' => $pass,
        'password_confirm' => $confirm
    ];
    
    $result = register_user($conn, $registrationData);
    
    if (!$result['success']) {
        $_SESSION['flash_error'] = strtoupper($result['message']);
        header('Location: /highstreetgym/controllers/auth/register_controller.php');
        exit;
    }

    // AUTO-LOGIN AFTER REGISTER - SET SESSION DATA CONSISTENTLY
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = (int)$result['user_id'];
    $_SESSION['user_type'] = 'member';
    $_SESSION['user_email'] = $email;
    $_SESSION['first_name'] = $first;
    $_SESSION['last_name'] = $last;

    // REDIRECT TO HOME
    header('Location: /highstreetgym/controllers/content/home_controller.php');
    exit;
}

// ENTRY POINT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handle_register();
} else {
    show_register_form();
}
