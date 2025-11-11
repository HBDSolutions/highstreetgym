<?php
// BASE LAYOUT SHELL
// EXPECTS: $pageTitle (string), $contentView (file path), $layout (array)

declare(strict_types=1);

// SAFETY GUARDS
$pageTitle    = $pageTitle   ?? 'High Street Gym';
$contentView  = $contentView ?? '';
$layout       = $layout      ?? [];

// NORMALISE LAYOUT PAYLOAD
$layout += [
    'currentPath'   => $_SERVER['REQUEST_URI'] ?? '/',
    'currentUser'   => $layout['currentUser']   ?? ['is_logged_in' => false, 'user_name' => '', 'user_type' => 'guest'],
    'showMemberNav' => $layout['showMemberNav'] ?? false,
    'showAdminNav'  => $layout['showAdminNav']  ?? false,
];

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?> - High Street Gym</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- HEADER -->
  <header>
    <?php include __DIR__ . '/../partials/nav.php'; ?>
  </header>

  <!-- MAIN -->
  <main class="flex-grow-1">
    <?php
      if ($contentView && is_file($contentView)) {
          include $contentView;
      } else {
          echo '<div class="container my-5"><div class="alert alert-danger">Content view not found.</div></div>';
      }
    ?>
  </main>

  <!-- FOOTER -->
  <footer>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>