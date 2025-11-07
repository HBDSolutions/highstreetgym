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
  <div class="container-fluid px-3">
    <a class="navbar-brand" href="/highstreetgym/controllers/content/home_controller.php">High Street Gym</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
        <!-- LEFT LINKS -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/home_controller.php', $currentPath); ?>" href="/highstreetgym/controllers/content/home_controller.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/classes_controller.php', $currentPath); ?>" href="/highstreetgym/controllers/content/classes_controller.php">Classes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/blog_controller.php', $currentPath); ?>" href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
        </li>

        <?php if ($isLoggedIn && !$isAdmin): ?>
            <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/bookings_controller.php', $currentPath); ?>" href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a>
            </li>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
            <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/admin_controller.php', $currentPath); ?>" href="/highstreetgym/controllers/content/admin_controller.php">Admin</a>
            </li>
        <?php endif; ?>
        </ul>

        <!-- RIGHT SIDE -->
        <ul class="navbar-nav ms-auto">
        <?php if ($isLoggedIn): ?>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php echo nav_active('/profile', $currentPath); ?>" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo htmlspecialchars($userName ?: 'Account'); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <?php if ($isAdmin): ?>
                <li><a class="dropdown-item" href="/highstreetgym/controllers/content/admin_controller.php">Admin Home</a></li>
                <li><hr class="dropdown-divider"></li>
                <?php else: ?>
                <li><a class="dropdown-item" href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a></li>
                <li><hr class="dropdown-divider"></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="/highstreetgym/controllers/auth/logout_controller.php">Logout</a></li>
            </ul>
            </li>
        <?php else: ?>
            <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/login_controller.php'); ?>" href="/highstreetgym/controllers/auth/login_controller.php">Login</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php echo nav_active('/register_controller.php'); ?>" href="/highstreetgym/controllers/auth/register_controller.php">Register</a>
            </li>
        <?php endif; ?>
        </ul>
    </div>
  </div>
</nav>