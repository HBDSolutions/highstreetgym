<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">High Street Gym</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= is_active('index.php') ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('classescontroller.php') ?>" href="/highstreetgym/controllers/classescontroller.php">Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('blog_controller.php') ?>" href="/highstreetgym/controllers/content/blog_controller.php">Blog</a>
                </li>
                
                <?php if ($showMemberMenu): ?>
                    <!-- Logged In User Menu -->
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('bookingcontroller.php') ?>" href="controllers/bookingcontroller.php">My Bookings</a>
                    </li>
                    
                    <?php if ($showAdminMenu): ?>
                        <!-- Admin Menu -->
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
                        <span class="nav-link text-white">Hello, <?= htmlspecialchars($userName) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controllers/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Not Logged In - Account Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="controllers/register.php">Register</a>
                            </li>
                        </ul>
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