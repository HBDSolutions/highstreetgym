<?php
declare(strict_types=1);

// REGISTER CONTROLLER

$VIEWS = __DIR__ . '/../../views';

// SHOW FORM
function show_register_form(): void {
    global $VIEWS;
    require $VIEWS . '/partials/header.php';
    require $VIEWS . '/partials/nav.php';
    require $VIEWS . '/auth/register.php';
    require $VIEWS . '/partials/footer.php';
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

    // CREATE USER using the available register_user function
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

    // AUTO-LOGIN AFTER REGISTER - Set session data consistently
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
