<?php
// NAVIGATION PARTIAL
// PURPOSE: RENDER TOP NAV FOR CORRECT ROLE

$isLoggedIn     = (bool)($isLoggedIn ?? ($currentUser['is_logged_in'] ?? false));
$isAdmin        = (bool)($isAdmin ?? (($currentUser['user_type'] ?? '') === 'admin'));
$showMemberMenu = (bool)($showMemberMenu ?? $isLoggedIn);
$showAdminMenu  = (bool)($showAdminMenu ?? $isAdmin);
$currentPath    = $currentPath ?? (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
$userName       = $currentUser['user_name'] ?? 'Account';
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

        <!-- MAIN LINKS -->
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

          <?php if ($showAdminMenu): ?>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('admin_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/admin_controller.php">Admin</a>
          </li>
          <?php endif; ?>

          <?php if ($showMemberMenu): ?>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('bookings_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a>
          </li>
          <?php endif; ?>
        </ul>

        <!-- AUTH -->
        <ul class="navbar-nav">
          <?php if (!$showMemberMenu): ?>
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
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($userName) ?>
              </a>
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