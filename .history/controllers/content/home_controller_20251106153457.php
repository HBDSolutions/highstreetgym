<?php
// HOME CONTROLLER
// PURPOSE: LOADS HOME PAGE AND SELECTS LAYOUT BASED ON USER ROLE

// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// READ AUTH STATE
$isLoggedIn = !empty($_SESSION['user_id'] ?? null);
$userType   = $isLoggedIn ? ($_SESSION['user_type'] ?? 'member') : 'guest';

// REQUIRED VIEW VARIABLES
$pageTitle   = 'Home';
$contentView = __DIR__ . '/../../views/content/home.php';

// SELECT LAYOUT CONTROLLER
if ($userType === 'admin') {
    require __DIR__ . '/../layouts/admin_layout.php';
} elseif ($isLoggedIn) {
    $memberLayout = __DIR__ . '/../layouts/member_layout.php';
    if (is_file($memberLayout)) {
        require $memberLayout;
    } else {
        require __DIR__ . '/../layouts/public_layout.php';
    }
} else {
    require __DIR__ . '/../layouts/public_layout.php';
}