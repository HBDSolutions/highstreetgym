<?php
// LOGIN CONTROLLER (FAILSAFE VERSION)

declare(strict_types=1);

// TURN ON ERRORS DURING DEBUG
error_reporting(E_ALL);
ini_set('display_errors', '1');

// START SESSION
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// DB
require_once __DIR__ . '/../../models/database.php';

// CSRF
if (empty($_SESSION['login_csrf'])) {
    $_SESSION['login_csrf'] = bin2hex(random_bytes(32));
}
function check_csrf(?string $t): bool {
    return isset($_SESSION['login_csrf']) && is_string($t) && hash_equals($_SESSION['login_csrf'], (string)$t);
}

// RENDER A MINIMAL, SELF-CONTAINED PAGE (NO PARTIALS)
function render_failsafe_login(?string $error = null): void {
    $token = htmlspecialchars($_SESSION['login_csrf'] ?? '', ENT_QUOTES);
    $err   = $error ? '<div style="background:#fee;border:1px solid #f99;color:#900;padding:.75rem 1rem;margin-bottom:1rem;border-radius:.25rem;">'
                    . htmlspecialchars($error, ENT_QUOTES) . '</div>' : '';
    echo <<<HTML
<!doctype html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sign In · High Street Gym</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container"><a class="navbar-brand" href="/highstreetgym/controllers/content/home_controller.php">High Street Gym</a></div>
</nav>
<main class="container" style="max-width:520px;">
  <h1 class="h3 mt-5 mb-4">Sign In</h1>
  {$err}
  <form method="post" action="">
    <input type="hidden" name="csrf_token" value="{$token}">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input id="email" name="email" type="email" class="form-control" required autofocus>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input id="password" name="password" type="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Sign In</button>
  </form>
  <p class="text-muted small mt-4">© 2025 High Street Gym</p>
</main>
</body>
</html>
HTML;
    exit;
}

// GET -> SHOW FORM
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    render_failsafe_login(null);
}

// POST -> AUTH
$email = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
$pass  = isset($_POST['password']) ? (string)$_POST['password'] : '';
$csrf  = isset($_POST['csrf_token']) ? (string)$_POST['csrf_token'] : '';

if (!check_csrf($csrf)) {
    render_failsafe_login('INVALID REQUEST. PLEASE TRY AGAIN.');
}
if ($email === '' || $pass === '') {
    render_failsafe_login('EMAIL AND PASSWORD ARE REQUIRED.');
}

try {
    $stmt = $conn->prepare('
        SELECT user_id, first_name, last_name, email, password_hash, user_type, status
        FROM users
        WHERE email = :email
        LIMIT 1
    ');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($pass, (string)$user['password_hash'])) {
        render_failsafe_login('INVALID EMAIL OR PASSWORD.');
    }
    if (isset($user['status']) && is_string($user['status']) && strtolower($user['status']) !== 'active') {
        render_failsafe_login('ACCOUNT IS INACTIVE.');
    }

    $_SESSION['user'] = [
        'user_id'      => (int)$user['user_id'],
        'first_name'   => (string)$user['first_name'],
        'last_name'    => (string)$user['last_name'],
        'email'        => (string)$user['email'],
        'user_type'    => (string)$user['user_type'],
        'status'       => (string)$user['status'],
        'logged_in_at' => time(),
    ];
    unset($_SESSION['login_csrf']);

    $role = strtolower((string)$user['user_type']);
    if ($role === 'admin') {
        header('Location: /highstreetgym/controllers/content/admin_controller.php');
    } else {
        header('Location: /highstreetgym/controllers/content/home_controller.php');
    }
    exit;

} catch (Throwable $e) {
    render_failsafe_login('UNEXPECTED ERROR. PLEASE TRY AGAIN.');
}
