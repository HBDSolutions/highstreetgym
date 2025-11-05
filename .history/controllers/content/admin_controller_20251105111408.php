<?php
declare(strict_types=1);

// ENTRY POINT
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// ACCESS CONTROL: ADMIN-ONLY PAGE GUARD
if (empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    http_response_code(403);
    echo '<h1>403 FORBIDDEN</h1><p>You do not have permission to access this page.</p>';
    exit;
}

// VIEW FLAG: ENABLE ADMIN MENU IN NAVIGATION
$showAdminMenu = true;

// INCLUDE HEADER, DASHBOARD, AND FOOTER
require __DIR__ . '/../../views/partials/header.php';
require __DIR__ . '/../../views/content/dashboard.php';
require __DIR__ . '/../../views/partials/footer.php';
