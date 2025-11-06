<?php
// PUBLIC LAYOUT VIEW
// PURPOSE: RENDERS PUBLIC PAGES AND INCLUDES $contentView

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? ($pageTitle ?? 'High Street Gym')) ?></title>

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>
<body class="public-layout">

  <!-- NAV -->
  <?php include __DIR__ . '/../partials/nav.php'; ?>

  <!-- MAIN CONTENT -->
  <main>
    <?php
    // EXPECTS $contentView TO BE A REAL FILE PATH
    if (isset($contentView) && is_file($contentView)) {
        include $contentView;
    } else {
        // SIMPLE FALLBACK SO THE PAGE ISN'T BLANK
        echo '<section class="container" style="padding:1rem 0 2rem;"><h1>Content not found</h1></section>';
    }
    ?>
  </main>

  <!-- FOOTER -->
  <?php
  $footer = __DIR__ . '/../partials/footer.php';
  if (is_file($footer)) { include $footer; }
  ?>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>