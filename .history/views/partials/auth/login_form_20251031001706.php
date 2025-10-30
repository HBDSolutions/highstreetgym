<!-- Login Form Partial -->
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
        <button type="submit" class="btn btn-secondary btn-lg">Login</button>
    </div>
</form>

<?php if ($showRegisterLink): ?>
    <p class="text-center mt-3">
        Don't have an account? 
        <a href="/highstreetgym/controllers/auth/register_controller.php">Register here</a>
    </p>
<?php endif; ?>