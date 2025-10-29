<?php

// NAVIGATION BAR 

// Prepare modal variables for login modal

// Get modal-specific error from session
$modalLoginError = $_SESSION['modal_login_error'] ?? null;
unset($_SESSION['modal_login_error']);

// Prepare flags for login form in modal
$showErrorAlert = !empty($modalLoginError);
$errorMessage = $modalLoginError ?? '';
$showSuccessAlert = false;
$showInfoAlert = false;
$infoMessage = '';
$successMessageText = '';
$showCardWrapper = false;
$showRegisterLink = false;
$formAction = 'controllers/authcontroller.php';
$previousEmail = '';
$redirectUrl = '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">High Street Gym</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="controllers/classes.php">Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="controllers/blog.php">Blog</a>
                </li>
                
                <?php if ($isLoggedIn): ?>
                    <!-- Logged In User Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="controllers/mybookings.php">
                            <i class="bi bi-calendar-check"></i> My Bookings
                        </a>
                    </li>
                    
                    <!-- Admin Menu (if admin) -->
                    <?php if ($userType === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i> Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="controllers/admin/users.php">Manage Users</a></li>
                                <li><a class="dropdown-item" href="controllers/admin/classes.php">Manage Classes</a></li>
                                <li><a class="dropdown-item" href="controllers/admin/trainers.php">Manage Trainers</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <i class="bi bi-person-circle"></i> Hello, <?= htmlspecialchars($userName) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controllers/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Not Logged In Menu -->
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-person-circle"></i> Login
                        </button>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="controllers/register.php" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Modal if not logged in -->
<?php if (!$isLoggedIn): ?>
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="loginModalLabel">
                      <i class="bi bi-person-circle"></i> Member Login
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <?php include __DIR__ . '/forms/login_form.php'; ?>
              </div>
              <div class="modal-footer">
                  <small class="text-muted">
                      Don't have an account? <a href="controllers/register.php">Register here</a>
                  </small>
              </div>
          </div>
      </div>
  </div>

  <!-- Show modal if login error -->
  <?php if ($showErrorAlert): ?>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
          loginModal.show();
      });
  </script>
  <?php endif; ?>
<?php endif; ?>