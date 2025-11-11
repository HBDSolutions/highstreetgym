<?php
// HOME CONTENT VIEW
// EXPECTS: $welcomeMessage, $showGuestButtons, $showMemberButtons
?>
<section class="container my-5">
  <header class="text-center mb-5">
    <h1 class="display-4"><?= htmlspecialchars($welcomeMessage ?? 'Welcome to High Street Gym') ?></h1>
    <p class="lead">Your journey to fitness starts here!</p>

    <?php if (!empty($showGuestButtons)): ?>
      <div class="mt-4">
        <a href="/highstreetgym/controllers/auth/register_controller.php" class="btn btn-primary btn-lg me-2">Join Now</a>
        <a href="/highstreetgym/controllers/auth/login_controller.php" class="btn btn-secondary btn-lg">Login</a>
      </div>
    <?php endif; ?>

    <?php if (!empty($showMemberButtons)): ?>
      <div class="mt-4">
        <a href="/highstreetgym/controllers/content/classes_controller.php" class="btn btn-primary btn-lg me-2">Browse Classes</a>
        <a href="/highstreetgym/controllers/content/bookings_controller.php" class="btn btn-primary btn-lg">My Bookings</a>
      </div>
    <?php endif; ?>
  </header>

  <!-- your three cards exactly as you have them -->
  <section class="row g-4 mb-5">
    <!-- ... cards ... -->
  </section>
</section>
