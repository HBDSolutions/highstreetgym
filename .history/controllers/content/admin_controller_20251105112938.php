<?php
// ADMIN CONTROLLER

declare(strict_types=1);

session_start();

// AUTHORISATION GUARD
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: /highstreetgym/controllers/content/home_controller.php');
    exit;
}

// PAGE TITLE FOR HEADER
$pageTitle = 'Admin — Home';

// INSERT HEADER, DASHBOARD, AND FOOTER
require __DIR__ . '/../../views/partials/header.php';
require __DIR__ . '/../../views/admin/dashboard.php';
require __DIR__ . '/../../views/partials/footer.php';
?>