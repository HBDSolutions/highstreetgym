<?php
// BASE LAYOUT VIEW
// RESPONSIBILITY: COMMON SITE-WIDE LAYOUT SHELL

// GUARD: REQUIRED VARIABLES
if (!isset($title, $contentView) || !is_file($contentView)) {
    die('Error: base layout missing $title or valid $contentView');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>
<body class="<?= isset($layoutRole) ? htmlspecialchars($layoutRole).'-layout' : 'public-layout' ?>">
  <div class="d-flex flex-column min-vh-100">
    <header>
      <?php include __DIR__ . '/../partials/nav.php'; ?>
    </header>

    <main class="flex-grow-1">
      <?php include $contentView; ?>
    </main>

    <footer class="mt-auto">
      <?php include __DIR__ . '/../partials/footer.php'; ?>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>