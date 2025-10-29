<?php

// LOGIN FORM

    if ($showCardWrapper): ?>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
    <?php endif; 
?>

<h2 class="<?= $showCardWrapper ? 'card-title text-center mb-4' : 'mb-3' ?>">
    <i class="bi bi-person-circle"></i> Member Login
</h2>

<!-- Success Alert -->
<?php if ($showSuccessAlert): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($successMessageText) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Error Alert -->
<?php if ($showErrorAlert): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($errorMessage) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Info Alert -->
<?php if ($showInfoAlert): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle"></i> <?= htmlspecialchars($infoMessage) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Login Form -->
<form method="POST" action="<?= htmlspecialchars($formAction) ?>" id="loginForm" novalidate>
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($previousEmail) ?>" 
                required
                autocomplete="email">
        <div class="invalid-feedback">Please enter a valid email address.</div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" 
                class="form-control" 
                id="password" 
                name="password" 
                required
                autocomplete="current-password">
        <div class="invalid-feedback">Please enter your password.</div>
    </div>

    <!-- Hidden redirect parameter -->
    <?php if ($redirectUrl): ?>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirectUrl) ?>">
    <?php endif; ?>

    <!-- Action identifier -->
    <input type="hidden" name="action" value="login">

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </button>
    </div>
</form>

<!-- Register Link -->
<?php if ($showRegisterLink): ?>
    <div class="text-center mt-4">
        <p class="mb-0">Don't have an account? 
            <a href="controllers/register.php" class="text-decoration-none">Register here</a>
        </p>
    </div>
<?php endif; ?>

<?php if ($showCardWrapper): ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- CLIENT-SIDE VALIDATION -->
<script>
    (function() {
        'use strict';
        
        const form = document.getElementById('loginForm');
        
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