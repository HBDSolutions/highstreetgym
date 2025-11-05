<?php
// LOGIN VIEW
// SESSION IS ALREADY STARTED BY THE CONTROLLER, SO WE DON'T NEED TO START IT HERE
$err = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_error']);
?>
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <h1 class="h3 mb-4 text-center">Sign In</h1>

      <?php if ($err): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($err, ENT_QUOTES) ?></div>
      <?php endif; ?>

      <form method="post" action="/highstreetgym/controllers/auth/login_controller.php" class="card p-4 shadow-sm">
        <!-- CSRF TOKEN HERE IF YOU USE ONE -->
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input id="email" name="email" type="email" class="form-control" required autocomplete="username"
                 value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input id="password" name="password" type="password" class="form-control" required autocomplete="current-password">
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Sign In</button>
        </div>
      </form>
    </div>
  </div>
</main>
