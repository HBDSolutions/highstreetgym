<?php
// BASE LAYOUT VIEW
if (!isset($title, $contentView, $layoutClass)) { die('BASE LAYOUT: MISSING REQUIRED VARIABLES'); }

if (!function_exists('get_navigation_data')) {
  require_once __DIR__ . '/../../models/navigation.php';
}
$navData = get_navigation_data();
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
<body class="<?= htmlspecialchars($layoutClass) ?> d-flex flex-column min-vh-100">
  <header><?php include __DIR__ . '/../partials/nav.php'; ?></header>

  <main class="flex-grow-1"><?php include $contentView; ?></main>

  <div class="mt-auto"><?php include __DIR__ . '/../partials/footer.php'; ?></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>