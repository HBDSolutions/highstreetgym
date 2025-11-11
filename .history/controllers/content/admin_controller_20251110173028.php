<?php
// ADMIN CONTROLLER
// PURPOSE: LOADS ADMIN HOME VIA ADMIN LAYOUT

declare(strict_types=1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';

// Require admin permission
require_permission('admin');

// Get authentication state
$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];
$userId = $currentUser['user_id'];
$userName = $currentUser['user_name'];
$userType = $currentUser['user_type'];

// Define view variables for admin layout
$pageTitle = 'Admin Home';
$title = $pageTitle . ' - High Street Gym';
$contentView = __DIR__ . '/../../views/admin/dashboard.php';

// USE ADMIN LAYOUT DIRECTLY (FOR ADMIN USERS)
require __DIR__ . '/../layouts/admin_layout.php';