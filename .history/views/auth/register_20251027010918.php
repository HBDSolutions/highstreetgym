<?php
/**
 * Member Registration Page
 * Uses Bootstrap 5 with High Street Gym custom theme
 */

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../controllers/AuthController.php';

$authController = new AuthController($conn);
$message = '';
$messageType = '';

// Server-side processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $authController->handleRegister();
    $message = $result['message'];
    $messageType = $result['success'] ? 'success' : 'danger';
    
    if ($result['success']) {
        header("refresh:2;url=login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration - High Street Gym</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom HSG Theme -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-brand">
            <div class="auth-brand-icon">🏋️</div>
            <h1>High Street Gym</h1>
            <p>Start Your Fitness Journey Today</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <form id="registerForm" method="POST" action="" novalidate>
            <div class="auth-form-row">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name <span class="required">*</span></label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John" required>
                    <div class="invalid-feedback" id="error-first_name">First name is required</div>
                </div>
                
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name <span class="required">*</span></label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Smith" required>
                    <div class="invalid-feedback" id="error-last_name">Last name is required</div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="required">*</span></label>
                <div class="input-icon-group">
                    <span class="input-icon">📧</span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="john.smith@email.com" required>
                </div>
                <div class="invalid-feedback" id="error-email">Valid email is required</div>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <div class="input-icon-group">
                    <span class="input-icon">📱</span>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="0412 345 678">
                </div>
                <div class="invalid-feedback" id="error-phone">Please enter a valid Australian mobile number</div>
            </div>
            
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-icon-group">
                    <span class="input-icon">🎂</span>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="required">*</span></label>
                <div class="input-icon-group">
                    <span class="input-icon">🔒</span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Min. 8 characters" required>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strength-bar"></div>
                </div>
                <div class="invalid-feedback" id="error-password">Password must be at least 8 characters</div>
            </div>
            
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password <span class="required">*</span></label>
                <div class="input-icon-group">
                    <span class="input-icon">🔒</span>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
                </div>
                <div class="invalid-feedback" id="error-confirm_password">Passwords must match</div>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
        
        <div class="auth-links">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        /**
         * CLIENT-SIDE VALIDATION
         */
        
        const form = document.getElementById('registerForm');
        const password = document.getElementById('password');
        const strengthBar = document.getElementById('strength-bar');
        
        // Password strength checker
        password.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            
            if (value.length >= 8) strength++;
            if (value.match(/[a-z]/) && value.match(/[A-Z]/)) strength++;
            if (value.match(/\d/)) strength++;
            if (value.match(/[^a-zA-Z\d]/)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            if (strength <= 1) {
                strengthBar.classList.add('weak');
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        });
        
        // Form validation
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            
            // Clear all errors
            document.querySelectorAll('.invalid-feedback').forEach(msg => {
                msg.classList.remove('show');
            });
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            // Validate first name
            const firstName = document.getElementById('first_name');
            if (firstName.value.trim() === '') {
                showError('first_name');
                isValid = false;
            }
            
            // Validate last name
            const lastName = document.getElementById('last_name');
            if (lastName.value.trim() === '') {
                showError('last_name');
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('email');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                showError('email');
                isValid = false;
            }
            
            // Validate phone (if provided)
            const phone = document.getElementById('phone');
            if (phone.value && !/^04\d{8}$/.test(phone.value.replace(/\s/g, ''))) {
                showError('phone');
                isValid = false;
            }
            
            // Validate password
            if (password.value.length < 8) {
                showError('password');
                isValid = false;
            }
            
            // Validate password confirmation
            const confirmPassword = document.getElementById('confirm_password');
            if (password.value !== confirmPassword.value) {
                showError('confirm_password');
                isValid = false;
            }
            
            if (isValid) {
                form.submit();
            }
        });
        
        function showError(fieldId) {
            const input = document.getElementById(fieldId);
            const error = document.getElementById('error-' + fieldId);
            input.classList.add('is-invalid');
            error.classList.add('show');
        }
        
        // Real-time validation feedback
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                    const errorMsg = document.getElementById('error-' + this.id);
                    if (errorMsg) errorMsg.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>