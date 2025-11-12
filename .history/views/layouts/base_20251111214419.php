<?php
// BASE LAYOUT SHELL
// PURPOSE: WRAPS PAGE, APPLIES STICKY FOOTER, INCLUDES NAV & FOOTER TO ALL PAGES

$pageTitle = $viewVars['title'] ?? 'High Street Gym';
?>

<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <header>
    <?php include __DIR__ . '/../partials/nav.php'; ?>
  </header>

  <main class="flex-grow-1">
    <?php
      if (!empty($viewVars['contentView'])) {
        include $viewVars['contentView'];
      }
    ?>
  </main>

  <?php include __DIR__ . '/../partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>