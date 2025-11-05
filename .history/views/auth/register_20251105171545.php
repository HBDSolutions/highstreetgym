<?php
// REGISTER VIEW
session_start();
$err = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_error']);
?>
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
      <h1 class="h3 mb-4 text-center">Create Account</h1>

      <?php if ($err): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($err, ENT_QUOTES) ?></div>
      <?php endif; ?>

      <form method="post" action="/highstreetgym/controllers/auth/register_controller.php" class="card p-4 shadow-sm">
        <!-- CSRF TOKEN HERE IF YOU USE ONE -->
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="first_name" class="form-label">First name</label>
            <input id="first_name" name="first_name" type="text" class="form-control" required
                   value="<?= htmlspecialchars($_POST['first_name'] ?? '', ENT_QUOTES) ?>">
          </div>
          <div class="col-sm-6">
            <label for="last_name" class="form-label">Last name</label>
            <input id="last_name" name="last_name" type="text" class="form-control" required
                   value="<?= htmlspecialchars($_POST['last_name'] ?? '', ENT_QUOTES) ?>">
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">
          </div>
          <div class="col-sm-6">
            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" type="password" class="form-control" required>
          </div>
          <div class="col-sm-6">
            <label for="confirm_password" class="form-label">Confirm password</label>
            <input id="confirm_password" name="confirm_password" type="password" class="form-control" required>
          </div>
        </div>

        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
      </form>
    </div>
  </div>
</main>
