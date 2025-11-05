<?php
// ADMIN CONTROLLER

declare(strict_types=1);

require_once __DIR__ . '/../../models/database.php';

class AdminController
{
    // SHOW DASHBOARD
    public function index(): void
    {
        session_start();

        // AUTHORISE ADMIN
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            http_response_code(403);
            echo 'FORBIDDEN';
            return;
        }

        // CSRF SEED
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // RENDER DASHBOARD
        require __DIR__ . '/../../views/admin/dashboard.php';
    }
}

// ENTRY POINT
$controller = new AdminController();
$controller->index();
?>