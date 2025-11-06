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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>
<body class="public-layout">

  <?php include __DIR__ . '/../partials/nav.php'; ?>

  <div class="container" style="padding:1rem 0 2rem;">
    <div style="padding:.5rem .75rem;margin:.5rem 0;background:#ffe8a1;border:1px solid #e0b100;border-radius:.25rem;">
      PUBLIC LAYOUT OK • contentView:
      <code><?= isset($contentView) ? htmlspecialchars($contentView) : 'NOT SET' ?></code>
      • exists:
      <strong><?= (isset($contentView) && is_file($contentView)) ? 'YES' : 'NO' ?></strong>
    </div>

    <?php
      if (isset($contentView) && is_file($contentView)) {
          include $contentView;
      } else {
          echo '<h1>Content not found</h1>';
      }
    ?>
  </div>

  <?php $footer = __DIR__ . '/../partials/footer.php'; if (is_file($footer)) { include $footer; } ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
