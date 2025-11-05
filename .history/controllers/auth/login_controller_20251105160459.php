<?php
// LOGIN CONTROLLER

declare(strict_types=1);

// START SESSION
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// DB
require_once __DIR__ . '/../../models/database.php';

// CSRF
function ensure_login_csrf_token(): void {
    if (empty($_SESSION['login_csrf'])) {
        $_SESSION['login_csrf'] = bin2hex(random_bytes(32));
    }
}
function check_login_csrf(?string $t): bool {
    return isset($_SESSION['login_csrf']) && is_string($t) && hash_equals($_SESSION['login_csrf'], $t);
}

// RENDER LOGIN VIEW (WITH FALLBACK)
function render_login_view(?string $error = null): void {
    $login_csrf = $_SESSION['login_csrf'] ?? '';
    $header = __DIR__ . '/../../views/partials/header.php';
    $footer = __DIR__ . '/../../views/partials/footer.php';
    $view   = __DIR__ . '/../../views/auth/login.php';

    if (is_file($header)) require $header;

    if (is_file($view)) {
        // EXPECTS THE VIEW TO USE $login_csrf AND OPTIONAL $error
        require $view;
    } else {
        // INLINE FALLBACK FORM
        ?>
        <main class="container my-5" style="max-width: 520px;">
            <h1 class="h3 mb-4">Sign In</h1>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($login_csrf, ENT_QUOTES) ?>">
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
        </main>
        <?php
    }

    if (is_file($footer)) require $footer;
    exit;
}

// GET -> SHOW FORM
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ensure_login_csrf_token();
    render_login_view(null);
}

// POST -> AUTH
ensure_login_csrf_token();

$email = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
$pass  = isset($_POST['password']) ? (string)$_POST['password'] : '';
$csrf  = isset($_POST['csrf_token']) ? (string)$_POST['csrf_token'] : '';

if (!check_login_csrf($csrf)) {
    render_login_view('INVALID REQUEST. PLEASE TRY AGAIN.');
}
if ($email === '' || $pass === '') {
    render_login_view('EMAIL AND PASSWORD ARE REQUIRED.');
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
        render_login_view('INVALID EMAIL OR PASSWORD.');
    }
    if (isset($user['status']) && is_string($user['status']) && strtolower($user['status']) !== 'active') {
        render_login_view('ACCOUNT IS INACTIVE.');
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
    render_login_view('UNEXPECTED ERROR. PLEASE TRY AGAIN.');
}