<!-- Login Content View -->
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <article class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Login to Your Account</h2>
                    
                    <?php if ($showSuccessAlert): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($successMessage) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($showErrorAlert): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Login Form -->
                    <form method="POST" action="<?= htmlspecialchars($formAction) ?>" id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email" 
                                    value="<?= htmlspecialchars($previousEmail) ?>" 
                                    required
                                    autocomplete="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" 
                                    class="form-control" 
                                    id="password" 
                                    name="password" 
                                    required
                                    autocomplete="current-password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <?php if ($showRegisterLink): ?>
                        <div class="text-center mt-4">
                            <p class="mb-0">Don't have an account? 
                                <a href="/highstreetgym/controllers/auth/register_controller.php" class="text-decoration-none">Register here</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </div>
</main>
