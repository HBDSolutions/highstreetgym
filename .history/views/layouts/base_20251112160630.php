<?php
// BASE LAYOUT VIEW
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/navigation.php';

// PAGE VARS (TITLE + CONTENT)
$title       = $title       ?? ($pageTitle ?? 'High Street Gym');
$contentView = $contentView ?? '';

// NAV VARS FOR PARTIAL
$navVars = get_navigation_data();
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

<body class="d-flex flex-column min-vh-100">
  <header>
    <?php include __DIR__ . '/../partials/nav.php'; ?>
  </header>

  <main class="flex-grow-1">
    <?php
      // CONTENT VIEW INCLUDE
      if ($contentView && file_exists($contentView)) {
        require $contentView;
      } else {
        echo '<div class="container my-5 text-danger">CONTENT MISSING</div>';
      }
    ?>
  </main>

  <?php include __DIR__ . '/../partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>