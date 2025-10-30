<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">High Street Gym</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
          <!-- Navigation Links -->
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link <?= is_active('home_controller.php') ?>" href="/highstreetgym/controllers/content/home_controller.php">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link <?= is_active('classes_controller.php') ?>" href="/highstreetgym/controllers/content/classes_controller.php">Classes</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link <?= is_active('blog_controller.php') ?>" href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
              </li>
              
              <?php if ($showMemberMenu): ?>
                  <li class="nav-item">
                      <a class="nav-link <?= is_active('bookings_controller.php') ?>" href="/highstreetgym/controllers/content/bookings_controller.php">My Bookings</a>
                  </li>
              <?php endif; ?>
              
              <?php if ($showAdminMenu): ?>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                          Admin
                      </a>
                      <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Manage Users</a></li>
                          <li><a class="dropdown-item" href="#">Manage Classes</a></li>
                      </ul>
                  </li>
              <?php endif; ?>
              
              <?php if ($isLoggedIn): ?>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                          Hello, <?= htmlspecialchars($userName) ?>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="/highstreetgym/controllers/content/bookings_controller.php">
                              <i class="bi bi-bookmark-check"></i> My Bookings
                          </a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="/highstreetgym/controllers/auth/logout_controller.php">
                              <i class="bi bi-box-arrow-right"></i> Logout
                          </a></li>
                      </ul>
                  </li>
              <?php else: ?>
                  <li class="nav-item">
                      <a class="nav-link" href="/highstreetgym/controllers/auth/login_controller.php">Login</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link btn btn-success text-white ms-2" href="/highstreetgym/controllers/auth/register_controller.php">Register</a>
                  </li>
              <?php endif; ?>
          </ul>
      </div>
    </div>
</nav>

<!-- Login Modal -->
<?php if ($showLoginButton): ?>
    <?php include __DIR__ . '/modals/login_modal.php'; ?>
<?php endif; ?>