<?php
// LOGIN CONTROLLER

declare(strict_types=1);
session_start();

// LOAD DB
require_once __DIR__ . '/../../models/database.php';

// HELPER: SAFE REDIRECT
function go(string $path): void {
    header('Location: ' . $path);
    exit;
}

// IF ALREADY LOGGED IN THEN ROUTE
if (!empty($_SESSION['user_id']) && !empty($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'admin') {
        go('/highstreetgym/controllers/content/admin_controller.php');
    } else {
        go('/highstreetgym/controllers/content/home_controller.php');
    }
}

// HANDLE POST
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'EMAIL AND PASSWORD ARE REQUIRED.';
    } else {
        // FETCH USER
        $stmt = $conn->prepare(
            'SELECT user_id, first_name, last_name, email, password_hash, user_type
             FROM users
             WHERE email = :email
             LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // VERIFY PASSWORD
        if ($user && password_verify($password, (string)$user['password_hash'])) {
            // SET SESSION
            $_SESSION['user_id']   = (int)$user['user_id'];
            $_SESSION['first_name'] = (string)$user['first_name'];
            $_SESSION['last_name']  = (string)$user['last_name'];
            $_SESSION['email']      = (string)$user['email'];
            $_SESSION['user_type']  = (string)$user['user_type'];

            // LANDING RULE: ADMINS TO DASHBOARD, OTHERS TO HOME
            if ($_SESSION['user_type'] === 'admin') {
                go('/highstreetgym/controllers/content/admin_controller.php');
            } else {
                go('/highstreetgym/controllers/content/home_controller.php');
            }
        } else {
            $error = 'INVALID EMAIL OR PASSWORD.';
        }
    }
}

// RENDER VIEW
$viewRoot = __DIR__ . '/../../views';
$pageTitle = 'Sign In';
include $viewRoot . '/partials/header.php';
include $viewRoot . '/partials/nav.php';

// MAKE $error AVAILABLE TO THE FORM VIEW
// EXPECTS: $error (STRING)
include $viewRoot . '/auth/login_form.php';

include $viewRoot . '/partials/footer.php';
