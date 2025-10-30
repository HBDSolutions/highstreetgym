<!-- Login Content View -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <?php if ($showCardWrapper): ?>
            <div class="card shadow">
                <div class="card-body p-4">
            <?php endif; ?>
            
                    <h2 class="text-center mb-4">Login to Your Account</h2>
                    
                    <!-- Success Alert -->
                    <?php if ($showSuccessAlert): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> <?= htmlspecialchars($successMessageText) ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Error Alert -->
                    <?php if ($showErrorAlert): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Login Form -->
                    <form method="POST" action="<?= htmlspecialchars($formAction) ?>">
                        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect'] ?? '/highstreetgym/controllers/content/home_controller.php') ?>">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                value="<?= htmlspecialchars($previousEmail) ?>"
                                placeholder="your.email@example.com"
                                required
                                autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your password"
                                required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>
                    </form>
                    
                    <?php if ($showRegisterLink): ?>
                        <div class="text-center mt-3">
                            <p class="mb-0">Don't have an account? 
                                <a href="/highstreetgym/controllers/auth/register_controller.php">Register here</a>
                            </p>
                        </div>
                    <?php endif; ?>
            
            <?php if ($showCardWrapper): ?>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>