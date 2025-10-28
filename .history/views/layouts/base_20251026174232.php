<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>High Street Gym</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
<body>
  <?php include 'views/partials/nav.php'; ?>
  <main>
    <?php include $view; ?>
  </main>
  <footer>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/highstreetgym/views/partials/footer.php"); ?>
  </footer>
</body>
</html>
