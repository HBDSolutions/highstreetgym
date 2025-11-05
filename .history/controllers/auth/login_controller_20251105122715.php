<?php
// LOGIN CONTROLLER

declare(strict_types=1);

// START SESSION
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// LOAD DB
require_once __DIR__ . '/../../models/database.php';

// CSRF HELPERS
function ensure_login_csrf_token(): void {
    if (empty($_SESSION['login_csrf'])) {
        $_SESSION['login_csrf'] = bin2hex(random_bytes(32));
    }
}
function check_login_csrf(?string $token): bool {
    return isset($_SESSION['login_csrf']) && is_string($token) && hash_equals($_SESSION['login_csrf'], $token);
}

// RENDER LOGIN VIEW
function render_login_view(?string $error = null): void {
    // MAKE $error AND CSRF TOKEN AVAILABLE TO THE VIEW
    $login_csrf = $_SESSION['login_csrf'] ?? '';
    // HEADER
    require __DIR__ . '/../../views/partials/header.php';
    // VIEW (ADAPT PATH IF YOUR LOGIN VIEW IS DIFFERENT)
    require __DIR__ . '/../../views/auth/login.php';
    // FOOTER
    require __DIR__ . '/../../views/partials/footer.php';
    exit;
}

// HANDLE GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ensure_login_csrf_token();
    render_login_view(null);
}

// HANDLE POST
ensure_login_csrf_token();

$email    = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';
$csrf     = isset($_POST['csrf_token']) ? (string)$_POST['csrf_token'] : '';

if (!check_login_csrf($csrf)) {
    render_login_view('INVALID REQUEST. PLEASE TRY AGAIN.');
}

if ($email === '' || $password === '') {
    render_login_view('EMAIL AND PASSWORD ARE REQUIRED.');
}

try {
    // LOOKUP USER BY EMAIL
    $stmt = $conn->prepare('
        SELECT user_id, first_name, last_name, email, password_hash, user_type, status
        FROM users
        WHERE email = :email
        LIMIT 1
    ');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        render_login_view('INVALID EMAIL OR PASSWORD.');
    }

    // VERIFY PASSWORD
    if (!password_verify($password, (string)$user['password_hash'])) {
        render_login_view('INVALID EMAIL OR PASSWORD.');
    }

    // OPTIONAL: REQUIRE ACTIVE STATUS
    if (isset($user['status']) && is_string($user['status']) && strtolower($user['status']) !== 'active') {
        render_login_view('ACCOUNT IS INACTIVE.');
    }

    // SET SESSION
    $_SESSION['user'] = [
        'user_id'    => (int)$user['user_id'],
        'first_name' => (string)$user['first_name'],
        'last_name'  => (string)$user['last_name'],
        'email'      => (string)$user['email'],
        'user_type'  => (string)$user['user_type'],
        'status'     => (string)$user['status'],
        'logged_in_at' => time(),
    ];

    // CLEAR ONE-TIME CSRF
    unset($_SESSION['login_csrf']);

    // REDIRECT: ADMIN -> DASHBOARD, OTHERS -> HOME
    $role = strtolower((string)$user['user_type']);
    if ($role === 'admin') {
        header('Location: /highstreetgym/controllers/content/admin_controller.php');
        exit;
    } else {
        header('Location: /highstreetgym/controllers/content/home_controller.php');
        exit;
    }

} catch (Throwable $e) {
    render_login_view('UNEXPECTED ERROR. PLEASE TRY AGAIN.');
}
