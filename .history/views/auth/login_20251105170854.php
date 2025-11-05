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
                    
                    <?php include __DIR__ . '/../auth/login_form.php'; ?>
                </div>
            </article>
        </div>
    </div>
</main>