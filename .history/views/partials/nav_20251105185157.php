<?php 

// NAV PARTIAL

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="<?= htmlspecialchars($homeHref) ?>">High Street Gym</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?= htmlspecialchars($homeHref) ?>">Home</a>
        </li>

        <?php if (!empty($showAdminMenu)): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admin</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/highstreetgym/controllers/content/admin_controller.php">Dashboard</a></li>
              <li><a class="dropdown-item" href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=members">Import Members (XML)</a></li>
              <li><a class="dropdown-item" href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=classes">Import Classes (XML)</a></li>
              <li><a class="dropdown-item" href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=schedules">Import Schedules (XML)</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if (!empty($isLoggedIn)): ?>
          <li class="nav-item">
            <span class="navbar-text me-3">Hello, <?= htmlspecialchars($userName) ?></span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/highstreetgym/controllers/auth/logout_controller.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/highstreetgym/controllers/auth/login_controller.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/highstreetgym/controllers/auth/register_controller.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
