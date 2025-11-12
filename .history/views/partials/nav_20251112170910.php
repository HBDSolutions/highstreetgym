<?php
// NAV PARTIAL: USES VARS FROM LAYOUT SHELL ONLY

// INPUTS
$currentUser    = $navVars['currentUser']    ?? [];
$isLoggedIn     = (bool)($navVars['isLoggedIn']     ?? false);
$isAdmin        = (bool)($navVars['isAdmin']        ?? false);
$showMemberMenu = (bool)($navVars['showMemberMenu'] ?? false);
$showAdminMenu  = (bool)($navVars['showAdminMenu']  ?? false);
$currentPath    = $navVars['currentPath']    ?? '/';
$userName       = $currentUser['user_name']  ?? 'Account';

// ACTIVE-LINK HELPER
if (!function_exists('a')) {
    function a($needle){ return nav_active($needle); }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
  <div class="container-fluid">
    <!-- BRAND (LEFT) -->
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
            <a class="nav-link <?= a('home_controller.php') ?>"
               href="/highstreetgym/controllers/content/home_controller.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= a('classes_controller.php') ?>"
               href="/highstreetgym/controllers/content/classes_controller.php">Classes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= a('blog_controller.php') ?>"
               href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
          </li>

          <?php if ($showAdminMenu): ?>
          <li class="nav-item">
            <a class="nav-link <?= a('admin_controller.php') ?>"
               href="/highstreetgym/controllers/content/admin_controller.php">Admin</a>
          </li>
          <?php endif; ?>
        </ul>

        <!-- AUTH -->
        <ul class="navbar-nav">
          <?php if (!$showMemberMenu): ?>
            <li class="nav-item">
              <a class="nav-link <?= a('login_controller.php') ?>"
                 href="/highstreetgym/controllers/auth/login_controller.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= a('register_controller.php') ?>"
                 href="/highstreetgym/controllers/auth/register_controller.php">Register</a>
            </li>
          <?php else: ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($userName) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($showMemberMenu && !$showAdminMenu): ?>
                  <li><a class="dropdown-item" href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a></li>
                <?php endif; ?>
                <?php if ($showAdminMenu): ?>
                  <li><a class="dropdown-item" href="/highstreetgym/controllers/content/admin_controller.php">Admin Home</a></li>
                <?php endif; ?>
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