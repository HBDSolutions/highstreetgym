<?php
// XML IMPORT RESULT VIEW FILE
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Import Result</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <main style="max-width: 720px; margin: 2rem auto; font-family: system-ui, Arial, sans-serif;">
    <h1>Import Result</h1>

    <?php if (!empty($error)): ?>
      <div style="padding: .75rem; background: #fee; border: 1px solid #fbb; border-radius: .5rem;">
        <?= htmlspecialchars($error) ?>
      </div>
      <p style="margin-top: 1rem;">
        <a href="/highstreetgym/controllers/content/xml_import_controller.php">Back</a>
      </p>
      <?php return; endif; ?>

    <?php if (!empty($report)): ?>
      <pre><?= htmlspecialchars(json_encode($report, JSON_PRETTY_PRINT), ENT_QUOTES) ?></pre>
    <?php else: ?>
      <p>No report available.</p>
    <?php endif; ?>

    <p style="margin-top: 1rem;">
      <a href="/highstreetgym/controllers/content/xml_import_controller.php">Back</a>
    </p>
  </main>
</body>
</html>
