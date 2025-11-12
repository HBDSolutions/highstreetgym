<?php
// BASE LAYOUT VIEW

?><!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'High Street Gym') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <header>
    <?php
      // Make nav helpers available and pass flags only (no logic in partial)
      $currentPath   = $currentPath ?? ($_SERVER['REQUEST_URI'] ?? '/');
      $isLoggedIn    = (bool)($isLoggedIn ?? (!empty($_SESSION['user_id'] ?? null)));
      $userType      = $userType   ?? ($isLoggedIn ? ($_SESSION['user_type'] ?? 'member') : 'guest');
      $currentUser   = $currentUser ?? [
        'user_name' => trim(($_SESSION['first_name'] ?? '').' '.($_SESSION['last_name'] ?? ''))
      ];
      $showMemberMenu = $showMemberMenu ?? $isLoggedIn;
      $showAdminMenu  = $showAdminMenu  ?? ($userType === 'admin');

      include __DIR__ . '/../partials/nav.php';
    ?>
  </header>

  <main class="flex-grow-1">
    <?php include $contentView; ?>
  </main>

  <div class="mt-auto">
    <?php include __DIR__ . '/../partials/footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>