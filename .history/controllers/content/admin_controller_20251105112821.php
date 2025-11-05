<?php
// ADMIN CONTROLLER

declare(strict_types=1);

session_start();

// AUTH GUARD
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: /highstreetgym/controllers/content/home_controller.php');
    exit;
}

// PAGE TITLE FOR HEADER
$pageTitle = 'Admin — Dashboard';

// LAYOUT START
require __DIR__ . '/../../views/partials/header.php';

// VIEW
require __DIR__ . '/../../views/admin/dashboard.php';

// LAYOUT END
require __DIR__ . '/../../views/partials/footer.php';
?>