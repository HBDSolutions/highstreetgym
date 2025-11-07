<?php
declare(strict_types=1);

// REGISTER CONTROLLER

// SHOW FORM (GET)
function show_register_form(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Define what to render; let the layout controller do the bootstrapping
    $pageTitle   = 'Register';
    $contentView = __DIR__ . '/../../views/auth/register.php';

    // Render through the public layout controller (loads base_layout + navigation helper)
    require_once __DIR__ . '/../layouts/public_layout.php';
}

// HANDLE SUBMIT (POST)
function handle_register(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $first   = trim((string)($_POST['first_name'] ?? ''));
    $last    = trim((string)($_POST['last_name'] ?? ''));
    $email   = trim((string)($_POST['email'] ?? ''));
    $pass    = (string)($_POST['password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    // Basic validation
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

    // Model calls
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/user_functions.php';

    $conn = get_database_connection();
    $result = register_user($conn, [
        'first_name'        => $first,
        'last_name'         => $last,
        'email'             => $email,
        'password'          => $pass,
        'password_confirm'  => $confirm,
    ]);

    if (!$result['success']) {
        $_SESSION['flash_error'] = strtoupper($result['message'] ?? 'REGISTRATION FAILED');
        header('Location: /highstreetgym/controllers/auth/register_controller.php');
        exit;
    }

    // Auto-login
    $_SESSION['logged_in']  = true;
    $_SESSION['user_id']    = (int)$result['user_id'];
    $_SESSION['user_type']  = 'member';
    $_SESSION['user_email'] = $email;
    $_SESSION['first_name'] = $first;
    $_SESSION['last_name']  = $last;

    header('Location: /highstreetgym/controllers/content/home_controller.php');
    exit;
}

// ENTRY
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handle_register();
} else {
    show_register_form();
}