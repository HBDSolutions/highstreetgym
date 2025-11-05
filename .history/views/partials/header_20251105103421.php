<?php
  // SET ADMIN MENU FLAG
  if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
  $showAdminMenu = !empty($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
?>

<header class="py-3 mb-3 border-bottom">
  <?php include __DIR__ . '/nav.php'; ?>
</header>