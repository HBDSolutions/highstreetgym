<?php
declare(strict_types=1);

// LOGIN CONTROLLER

// SHOW FORM
function show_login_form(): void {
    // START SESSION IF NEEDED
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // INCLUDE DEPENDENCIES
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/session.php';

    // GET AUTHENTICATION STATE FOR LAYOUT
    $currentUser = get_current_user_display();
    $isLoggedIn = $currentUser['is_logged_in'];
    $userId = $currentUser['user_id'];
    $userName = $currentUser['user_name'];
    $userType = $currentUser['user_type'];

    // PREPARE LOGIN FORM CONTEXT DATA
    $err = $_SESSION['flash_error'] ?? '';
    unset($_SESSION['flash_error']);
    
    $loginFormContext = [
        'showErrorAlert' => !empty($err),
        'errorMessage' => $err,
        'formAction' => '/highstreetgym/controllers/auth/login_controller.php',
        'showSuccessAlert' => false,
        'showInfoAlert' => false,
        'infoMessage' => '',
        'successMessageText' => '',
        'previousEmail' => $_POST['email'] ?? '',
        'redirectUrl' => $_GET['redirect'] ?? ''
    ];

    // DEFINE VIEW VARIABLES FOR PUBLIC LAYOUT
    $pageTitle = 'Login';
    $title = $pageTitle . ' - High Street Gym';
    $contentView = __DIR__ . '/../../views/auth/login.php';

    // USE PUBLIC LAYOUT DIRECTLY (FOR UNAUTHENTICATED USERS)
    require __DIR__ . '/../../views/layouts/public.php';
}

// HANDLE POST
function handle_login(): void {
    session_start();

    // BASIC INPUTS
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    // USE THE AVAILABLE LOGIN_USER FUNCTION
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/user_functions.php';
    
    $conn = get_database_connection();
    $result = login_user($conn, $email, $password);

    if ($result['success']) {
        $user = $result['user'];
        
        // SET SESSION DATA CONSISTENTLY WITH SESSION MODEL EXPECTATIONS
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = (int)$user['user_id'];
        $_SESSION['user_type'] = (string)$user['user_type'];
        $_SESSION['user_email'] = (string)$user['email'];
        $_SESSION['first_name'] = (string)($user['first_name'] ?? '');
        $_SESSION['last_name'] = (string)($user['last_name'] ?? '');

        // REDIRECT ADMINS TO DASHBOARD, EVERYONE ELSE TO HOME
        if (strtolower($_SESSION['user_type']) === 'admin') {
            header('Location: /highstreetgym/controllers/content/admin_controller.php');
        } else {
            header('Location: /highstreetgym/controllers/content/home_controller.php');
        }
        exit;
    }

    // ON FAIL, REDISPLAY FORM WITH MESSAGE
    $_SESSION['flash_error'] = strtoupper($result['message']);
    header('Location: /highstreetgym/controllers/auth/login_controller.php');
    exit;
}

// ENTRY POINT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handle_login();
} else {
    show_login_form();
}
