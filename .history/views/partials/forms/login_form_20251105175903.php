<?php
// DUMB LOGIN FORM COMPONENT - EXTRACTED FROM EXISTING LOGIN.PHP
// EXPECTS $loginFormContext TO BE PROVIDED
// THIS IS JUST THE FORM PART, NOT A FULL PAGE
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
        <input id="email" 
               name="email" 
               type="email" 
               class="form-control" 
               required 
               autocomplete="username"
               value="<?= htmlspecialchars($loginFormContext['previousEmail']) ?>">
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" 
               name="password" 
               type="password" 
               class="form-control" 
               required 
               autocomplete="current-password">
    </div>
    
    <?php if (!empty($loginFormContext['redirectUrl'])): ?>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($loginFormContext['redirectUrl']) ?>">
    <?php endif; ?>
    
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Sign In</button>
    </div>
</form>