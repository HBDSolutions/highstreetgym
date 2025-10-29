<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">
                    <i class="bi bi-person-circle"></i> Member Login
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php 
                // Modal context
                $loginFormContext = $loginModalContext;
                include __DIR__ . '/../forms/login_form.php'; 
                ?>
            </div>
            <div class="modal-footer">
                <small class="text-muted">
                    Don't have an account? <a href="controllers/register.php">Register here</a>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Show modal if error exists -->
<?php if ($showLoginModal): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    });
</script>
<?php endif; ?>