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
                $showErrorAlert = $loginModal_showErrorAlert;
                $errorMessage = $loginModal_errorMessage;
                $showSuccessAlert = $loginModal_showSuccessAlert;
                $showInfoAlert = $loginModal_showInfoAlert;
                $infoMessage = $loginModal_infoMessage;
                $successMessageText = $loginModal_successMessageText;
                $showCardWrapper = $loginModal_showCardWrapper;
                $showRegisterLink = $loginModal_showRegisterLink;
                $formAction = $loginModal_formAction;
                $previousEmail = $loginModal_previousEmail;
                $redirectUrl = $loginModal_redirectUrl;
                
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

<!-- Show modal if login error exists -->
<?php if ($showLoginModal): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    });
</script>
<?php endif;
?>