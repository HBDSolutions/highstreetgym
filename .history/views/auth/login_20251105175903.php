<?php
// DUMB LOGIN PAGE VIEW
// SESSION IS ALREADY STARTED BY THE CONTROLLER, SO WE DON'T NEED TO START IT HERE
// EXPECTS $loginFormContext TO BE PROVIDED BY CONTROLLER
?>
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <h1 class="h3 mb-4 text-center">Sign In</h1>

      <div class="card p-4 shadow-sm">
        <?php include __DIR__ . '/../partials/forms/login_form.php'; ?>
      </div>
      
      <div class="text-center mt-3">
        <small class="text-muted">
          Don't have an account? <a href="/highstreetgym/controllers/auth/register_controller.php">Register here</a>
        </small>
      </div>
    </div>
  </div>
</main>
