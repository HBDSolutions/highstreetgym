<?php
// HOME CONTROLLER
// PURPOSE: Loads Home page and selects layout based on user role

// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// READ AUTH STATE FROM SESSION (no DB calls here)
$isLoggedIn = !empty($_SESSION['user_id']);
$userType   = $isLoggedIn ? ($_SESSION['user_type'] ?? 'member') : 'guest';
$userName   = $isLoggedIn ? trim(($_SESSION['first_name'] ?? '').' '.($_SESSION['last_name'] ?? '')) : '';

// VIEW VARIABLES REQUIRED BY LAYOUT
$pageTitle   = 'Home';
$contentView = __DIR__ . '/../../views/content/home.php';

// VIEW DATA FOR home.php (dumb view uses these)
$welcomeMessage   = $isLoggedIn && $userName !== '' ? "Welcome back, {$userName}" : 'Welcome to High Street Gym';
$showGuestButtons = !$isLoggedIn;
$showMemberButtons= $isLoggedIn && $userType === 'member';

// SELECT LAYOUT CONTROLLER (thin; they include base_layout.php themselves)
if ($userType === 'admin') {
    require __DIR__ . '/../layouts/admin_layout.php';
} elseif ($isLoggedIn) {
    require __DIR__ . '/../layouts/member_layout.php';
} else {
    require __DIR__ . '/../layouts/public_layout.php';
}