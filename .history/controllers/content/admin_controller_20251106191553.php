<?php
// ADMIN CONTROLLER

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// ACCESS CONTROL
$user = $_SESSION['user'] ?? null;
if (!isset($user['user_type']) || $user['user_type'] !== 'admin') {
    header('Location: /highstreetgym/controllers/content/home_controller.php');
    exit;
}

// LAYOUT FLAGS
$pageTitle      = 'Admin Dashboard';
$activeNav      = 'admin';
$showAdminMenu  = true;

// CONTROLLER
class AdminController
{
    public function index(): void
    {
        $this->dashboard();
    }

    public function dashboard(): void
    {
        // INCLUDE HEADER, DASHBOARD VIEW, FOOTER
        require __DIR__ . '/../../views/partials/header.php';
        require __DIR__ . '/../../views/admin/dashboard.php';
        require __DIR__ . '/../../views/partials/footer.php';
    }
}

// ENTRY POINT
$controller = new AdminController();
$controller->index();
