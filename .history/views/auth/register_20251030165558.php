<!-- Register Content View -->
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Create Your Account</h2>
                    
                    <!-- Error Summary -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Please correct the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $field => $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Registration Form -->
                    <form method="POST" action="/highstreetgym/controllers/auth/register_controller.php">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="<?= htmlspecialchars($formData['first_name']) ?>"
                                    placeholder="John"
                                    required>
                                <?php if (isset($errors['first_name'])): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($errors['first_name']) ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" 
                                    id="last_name" 
                                    name="last_name" 
                                    value="<?= htmlspecialchars($formData['last_name']) ?>"
                                    placeholder="Doe"
                                    required>
                                <?php if (isset($errors['last_name'])): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($errors['last_name']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input 
                                type="email" 
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                id="email" 
                                name="email" 
                                value="<?= htmlspecialchars($formData['email']) ?>"
                                placeholder="your.email@example.com"
                                required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input 
                                type="tel" 
                                class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                                id="phone" 
                                name="phone" 
                                value="<?= htmlspecialchars($formData['phone']) ?>"
                                placeholder="0412 345 678">
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                id="password" 
                                name="password" 
                                placeholder="Minimum 8 characters"
                                required>
                            <div class="form-text">Must be at least 8 characters long</div>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirm" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                id="password_confirm" 
                                name="password_confirm" 
                                placeholder="Re-enter your password"
                                required>
                            <?php if (isset($errors['password_confirm'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['password_confirm']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-person-plus"></i> Create Account
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account? 
                            <a href="/highstreetgym/controllers/auth/login_controller.php">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>