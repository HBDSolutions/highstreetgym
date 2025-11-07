<?php
// views/partials/nav.php
// Assumes the layout controller (via base_layout.php) has prepared:
// $isLoggedIn (bool), $userType ('guest'|'member'|'admin'),
// $currentUser (array with ['user_name' => '...']),
// $currentPath (string), and helper nav_active($needle, ?$currentPath)

// Defensive defaults if something isn't set (keeps view dumb & resilient)
$isLoggedIn   = isset($isLoggedIn)   ? (bool)$isLoggedIn   : false;
$userType     = isset($userType)     ? (string)$userType   : 'guest';
$currentUser  = isset($currentUser)  && is_array($currentUser) ? $currentUser : ['user_name' => ''];
$currentPath  = isset($currentPath)  ? (string)$currentPath  : ($_SERVER['REQUEST_URI'] ?? '/');

// Convenience flags
$isAdmin      = $isLoggedIn && ($userType === 'admin');
$userNameSafe = htmlspecialchars($currentUser['user_name'] ?? '', ENT_QUOTES, 'UTF-8');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
  <div class="container">
    <!-- Brand -->
    <a class="navbar-brand" href="/highstreetgym/controllers/content/home_controller.php">
      High Street Gym
    </a>

    <!-- Mobile toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible -->
    <div class="collapse navbar-collapse" id="mainNav">
      <!-- Left (primary) links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= nav_active('/home_controller.php', $currentPath) ?>"
             href="/highstreetgym/controllers/content/home_controller.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= nav_active('/classes_controller.php', $currentPath) ?>"
             href="/highstreetgym/controllers/content/classes_controller.php">Classes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= nav_active('/blog_controller.php', $currentPath) ?>"
             href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
        </li>

        <?php if ($isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('/bookings_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a>
          </li>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('/admin_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/content/admin_controller.php">Admin</a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Right auth area -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (!$isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('/login_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/auth/login_controller.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= nav_active('/register_controller.php', $currentPath) ?>"
               href="/highstreetgym/controllers/auth/register_controller.php">Register</a>
          </li>
        <?php else: ?>
          <!-- User dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              <?= $userNameSafe !== '' ? $userNameSafe : 'Account' ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li>
                <a class="dropdown-item" href="/highstreetgym/controllers/content/profile_controller.php">Profile</a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="/highstreetgym/controllers/auth/logout_controller.php">Logout</a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
