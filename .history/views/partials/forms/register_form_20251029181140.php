<?php

// REGISTRATION FORM

// Extract context variables
$showErrorAlert = $registerFormContext['showErrorAlert'] ?? false;
$errorMessage = $registerFormContext['errorMessage'] ?? '';
$fieldErrors = $registerFormContext['fieldErrors'] ?? [];
$showCardWrapper = $registerFormContext['showCardWrapper'] ?? false;
$showLoginLink = $registerFormContext['showLoginLink'] ?? true;
$formAction = $registerFormContext['formAction'] ?? 'controllers/register.php';
$previousData = $registerFormContext['previousData'] ?? [];
?>

<?php if ($showCardWrapper): ?>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
<?php endif; ?>

<h2 class="<?= $showCardWrapper ? 'card-title text-center mb-4' : 'mb-3' ?>">
    <i class="bi bi-person-plus"></i> Member Registration
</h2>

<!-- General Error Alert -->
<?php if ($showErrorAlert): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($errorMessage) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Registration Form -->
<form method="POST" action="<?= htmlspecialchars($formAction) ?>" id="registerForm" novalidate>
    <div class="row">
        <!-- First Name -->
        <div class="col-md-6 mb-3">
            <label for="first_name" class="form-label">First Name *</label>
            <input type="text" 
                   class="form-control <?= isset($fieldErrors['first_name']) ? 'is-invalid' : '' ?>" 
                   id="first_name" 
                   name="first_name" 
                   value="<?= htmlspecialchars($previousData['first_name'] ?? '') ?>" 
                   required
                   minlength="2"
                   maxlength="50">
            <?php if (isset($fieldErrors['first_name'])): ?>
                <div class="invalid-feedback d-block">
                    <?= htmlspecialchars($fieldErrors['first_name']) ?>
                </div>
            <?php else: ?>
                <div class="invalid-feedback">Please enter your first name (2-50 characters).</div>
            <?php endif; ?>
        </div>

        <!-- Last Name -->
        <div class="col-md-6 mb-3">
            <label for="last_name" class="form-label">Last Name *</label>
            <input type="text" 
                   class="form-control <?= isset($fieldErrors['last_name']) ? 'is-invalid' : '' ?>" 
                   id="last_name" 
                   name="last_name" 
                   value="<?= htmlspecialchars($previousData['last_name'] ?? '') ?>" 
                   required
                   minlength="2"
                   maxlength="50">
            <?php if (isset($fieldErrors['last_name'])): ?>
                <div class="invalid-feedback d-block">
                    <?= htmlspecialchars($fieldErrors['last_name']) ?>
                </div>
            <?php else: ?>
                <div class="invalid-feedback">Please enter your last name (2-50 characters).</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address *</label>
        <input type="email" 
               class="form-control <?= isset($fieldErrors['email']) ? 'is-invalid' : '' ?>" 
               id="email" 
               name="email" 
               value="<?= htmlspecialchars($previousData['email'] ?? '') ?>" 
               required
               autocomplete="email">
        <?php if (isset($fieldErrors['email'])): ?>
            <div class="invalid-feedback d-block">
                <?= htmlspecialchars($fieldErrors['email']) ?>
            </div>
        <?php else: ?>
            <div class="invalid-feedback">Please enter a valid email address.</div>
        <?php endif; ?>
    </div>

    <!-- Phone -->
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number (Optional)</label>
        <input type="tel" 
               class="form-control <?= isset($fieldErrors['phone']) ? 'is-invalid' : '' ?>" 
               id="phone" 
               name="phone" 
               value="<?= htmlspecialchars($previousData['phone'] ?? '') ?>"
               placeholder="e.g. 0412 345 678">
        <?php if (isset($fieldErrors['phone'])): ?>
            <div class="invalid-feedback d-block">
                <?= htmlspecialchars($fieldErrors['phone']) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password *</label>
        <input type="password" 
               class="form-control <?= isset($fieldErrors['password']) ? 'is-invalid' : '' ?>" 
               id="password" 
               name="password" 
               required
               minlength="8"
               autocomplete="new-password">
        <div class="form-text">
            Must be at least 8 characters with uppercase, lowercase, and number
        </div>
        <?php if (isset($fieldErrors['password'])): ?>
            <div class="invalid-feedback d-block">
                <?= htmlspecialchars($fieldErrors['password']) ?>
            </div>
        <?php else: ?>
            <div class="invalid-feedback">Please enter a valid password.</div>
        <?php endif; ?>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirm" class="form-label">Confirm Password *</label>
        <input type="password" 
               class="form-control <?= isset($fieldErrors['password_confirm']) ? 'is-invalid' : '' ?>" 
               id="password_confirm" 
               name="password_confirm" 
               required
               autocomplete="new-password">
        <?php if (isset($fieldErrors['password_confirm'])): ?>
            <div class="invalid-feedback d-block">
                <?= htmlspecialchars($fieldErrors['password_confirm']) ?>
            </div>
        <?php else: ?>
            <div class="invalid-feedback">Passwords must match.</div>
        <?php endif; ?>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-person-plus"></i> Register
        </button>
    </div>
</form>

<!-- Login Link -->
<?php if ($showLoginLink): ?>
    <div class="text-center mt-4">
        <p class="mb-0">Already have an account? 
            <a href="login.php" class="text-decoration-none">Login here</a>
        </p>
    </div>
<?php endif; ?>

<?php if ($showCardWrapper): ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Client-side validation -->
<script>
    (function() {
        'use strict';
        
        const form = document.getElementById('registerForm');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirm');
        
        // Password match validation
        passwordConfirm.addEventListener('input', function() {
            if (password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Passwords must match');
            } else {
                passwordConfirm.setCustomValidity('');
            }
        });
        
        if (form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }
    })();
</script>