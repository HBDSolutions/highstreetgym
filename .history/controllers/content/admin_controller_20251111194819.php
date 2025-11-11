<?php
// ADMIN CONTROLLER
// PURPOSE: LOADS ADMIN HOME

declare(strict_types=1);

// Start session
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';

require_permission('admin');

$currentUser = get_current_user_display();
$pageTitle   = 'Admin Home';
$contentView = __DIR__ . '/../../views/admin/dashboard.php';

require __DIR__ . '/../layouts/admin_layout.php';