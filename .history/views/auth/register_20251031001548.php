<!-- Register Content View -->
<main class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <article class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Create Your Account</h2>
                    
                    <?php if ($showErrors): ?>
                        <div class="alert alert-danger">
                            <strong>Please correct the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $field => $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php include __DIR__ . '/../partials/auth/register_form.php'; ?>
                </div>
            </article>
        </div>
    </div>
</main>