<?php
// NAVIGATION PARTIAL
// PURPOSE: RENDERS TOP NAV USING VARIABLES PROVIDED BY LAYOUT

// USE PROVIDED VARIABLES WHEN AVAILABLE; FALL BACK SAFELY
$currentPath = $currentPath ?? ($_SERVER['REQUEST_URI'] ?? '');
$isLoggedIn  = isset($isLoggedIn) ? $isLoggedIn : (!empty($_SESSION['user_id'] ?? null));
$userName    = $userName   ?? trim(($isLoggedIn ? (($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) : ''));
$userType    = $userType   ?? ($isLoggedIn ? ($_SESSION['user_type'] ?? 'member') : 'guest');
$isAdmin     = $isAdmin    ?? ($userType === 'admin');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
  <div class="container-fluid"><!-- fluid so items hit the edges -->
    <!-- BRAND (left) -->
    <a class="navbar-brand" href="/highstreetgym/controllers/content/home_controller.php">High Street Gym</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <!-- MAIN LINKS (push right) -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0"><!-- ms-auto = push to right -->
        <li class="nav-item">
          <a class="nav-link <?= nav_active('home_controller.php') ?>" href="/highstreetgym/controllers/content/home_controller.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= nav_active('classes_controller.php') ?>" href="/highstreetgym/controllers/content/classes_controller.php">Classes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= nav_active('blog_controller.php') ?>" href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
        </li>
        <?php if (!empty($showAdminMenu)): ?>
        <li class="nav-item">
          <a class="nav-link <?= nav_active('admin_controller.php') ?>" href="/highstreetgym/controllers/content/admin_controller.php">Admin</a>
        </li>
        <?php endif; ?>
      </ul>

      <!-- AUTH (stay right, slight gap) -->
      <ul class="navbar-nav ms-3">
        <?php if (empty($showMemberMenu)): ?>
          <li class="nav-item"><a class="nav-link <?= nav_active('login_controller.php') ?>" href="/highstreetgym/controllers/auth/login_controller.php">Login</a></li>
          <li class="nav-item"><a class="nav-link <?= nav_active('register_controller.php') ?>" href="/highstreetgym/controllers/auth/register_controller.php">Register</a></li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= htmlspecialchars($currentUser['user_name'] ?? 'Account') ?></a>
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
</nav>