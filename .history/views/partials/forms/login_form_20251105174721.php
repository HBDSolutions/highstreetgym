<?php
// DUMB LOGIN FORM VIEW - EXPECTS $loginFormContext TO BE PROVIDED
// NO BUSINESS LOGIC OR DATA MANIPULATION HERE
?>

<?php if ($loginFormContext['showErrorAlert']): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($loginFormContext['errorMessage']) ?>
    </div>
<?php endif; ?>

<?php if ($loginFormContext['showSuccessAlert']): ?>
    <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($loginFormContext['successMessageText']) ?>
    </div>
<?php endif; ?>

<?php if ($loginFormContext['showInfoAlert']): ?>
    <div class="alert alert-info" role="alert">
        <?= htmlspecialchars($loginFormContext['infoMessage']) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= htmlspecialchars($loginFormContext['formAction']) ?>">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control" 
               id="email" 
               name="email" 
               required 
               autocomplete="username"
               value="<?= htmlspecialchars($loginFormContext['previousEmail']) ?>">
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
    
    <?php if (!empty($loginFormContext['redirectUrl'])): ?>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($loginFormContext['redirectUrl']) ?>">
    <?php endif; ?>
    
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
</form>

<?php if ($loginFormContext['showRegisterLink']): ?>
    <div class="text-center mt-3">
        <small class="text-muted">
            Don't have an account? <a href="/highstreetgym/controllers/auth/register_controller.php">Register here</a>
        </small>
    </div>
<?php endif; ?>