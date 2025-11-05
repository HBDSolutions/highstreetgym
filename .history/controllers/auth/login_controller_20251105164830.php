<?php
declare(strict_types=1);

// LOGIN CONTROLLER

// BASE VIEW PATH
$VIEWS = __DIR__ . '/../../views';

// SHOW FORM
function show_login_form(): void {
    global $VIEWS;
    // HEADER + NAV
    require $VIEWS . '/partials/header.php';
    require $VIEWS . '/partials/nav.php';
    // PAGE BODY
    require $VIEWS . '/auth/login_form.php';
    // FOOTER
    require $VIEWS . '/partials/footer.php';
}

// HANDLE POST
function handle_login(): void {
    session_start();

    // BASIC INPUTS
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    // TODO: REPLACE WITH EXISTING AUTH LOOKUP
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/user_functions.php';
    $user = authenticate_user($email, $password); // RETURNS ARRAY OR NULL

    if ($user) {
        $_SESSION['user_id']   = (int)$user['user_id'];
        $_SESSION['user_type'] = (string)$user['user_type'];

        // REDIRECT ADMINS TO DASHBOARD, EVERYONE ELSE TO HOME
        if (strtolower($_SESSION['user_type']) === 'admin') {
            header('Location: /highstreetgym/controllers/content/admin_controller.php');
        } else {
            header('Location: /highstreetgym/controllers/content/home_controller.php');
        }
        exit;
    }

    // ON FAIL, REDISPLAY FORM WITH MESSAGE
    $_SESSION['flash_error'] = 'INVALID EMAIL OR PASSWORD.';
    header('Location: /highstreetgym/controllers/auth/login_controller.php');
    exit;
}

// ENTRY POINT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handle_login();
} else {
    show_login_form();
}
