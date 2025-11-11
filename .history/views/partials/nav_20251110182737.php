<?php
// NAV PARTIAL (ROBUST)

// ENSURE SESSION
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// ENSURE HELPERS
if (!function_exists('get_navigation_data')) { require_once __DIR__ . '/../../models/navigation.php'; }
if (!function_exists('nav_active'))          { require_once __DIR__ . '/../../models/navigation.php'; }

// MODEL DATA (TOLERANT OF DIFFERENT SHAPES)
$nav = get_navigation_data() ?? [];

$currentPath = $_SERVER['REQUEST_URI'] ?? '';

$sessionLoggedIn = !empty($_SESSION['user_id'] ?? null);
$sessionIsAdmin  = (($_SESSION['user_type'] ?? '') === 'admin');
$sessionName     = trim(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? ''));

// NORMALISE FLAGS
$isLoggedIn  = $nav['is_logged_in'] ?? $nav['showMemberMenu'] ?? $sessionLoggedIn;
$isAdmin     = $nav['is_admin']     ?? $nav['showAdminMenu']   ?? $sessionIsAdmin;
$displayName = $nav['user_name']    ?? $sessionName            ?? 'Account';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
  <div class="container-fluid">
    <a class="navbar-brand" href="/highstreetgym/controllers/content/home_controller.php">High Street Gym</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <div class="ms-auto d-flex align-items-center">

        <ul class="navbar-nav me-3 mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?= nav_active('home_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/home_controller.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('classes_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/classes_controller.php">Classes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('blog_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
          </li>
          <?php if ($isAdmin): ?>
            <li class="nav-item">
              <a class="nav-link <?= nav_active('admin_controller.php', $currentPath) ?>"
                 href="/highstreetgym/controllers/content/admin_controller.php">Admin</a>
            </li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav">
          <?php if (!$isLoggedIn): ?>
            <li class="nav-item">
              <a class="nav-link <?= nav_active('login_controller.php', $currentPath) ?>"
                 href="/highstreetgym/controllers/auth/login_controller.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= nav_active('register_controller.php', $currentPath) ?>"
                 href="/highstreetgym/controllers/auth/register_controller.php">Register</a>
            </li>
          <?php else: ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                 aria-expanded="false"><?= htmlspecialchars($displayName ?: 'Account') ?></a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/highstreetgym/controllers/auth/logout_controller.php">Logout</a></li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>

      </div>
    </div>
  </div>
</nav>