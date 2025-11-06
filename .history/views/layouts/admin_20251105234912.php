<?php
// PREPARE NAVIGATION DATA FOR DUMB VIEW
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/navigation.php';
$navData = get_navigation_data();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?></title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
    </head>
    <body class="admin-layout">
        <!-- Admin Navigation -->
        <?php include __DIR__ . '/../partials/nav.php'; ?>
        
        <!-- Main Content -->
        <main>
            <?php include $contentView; ?>
        </main>
        
        <!-- Footer -->
        <?php include __DIR__ . '/../partials/footer.php'; ?>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>