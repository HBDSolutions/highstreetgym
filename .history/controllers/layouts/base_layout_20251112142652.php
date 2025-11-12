<?php
// BASE LAYOUT BOOTSTRAP

function init_base_layout(): array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // INCLUDE MODELS FOR LAYOUT STATE
    require_once __DIR__ . '/../../models/session.php';
    require_once __DIR__ . '/../../models/navigation.php';

    // CURRENT USER SNAPSHOT
    $currentUser = get_current_user_display();

    // ROLE FLAGS
    $isLoggedIn = (bool)($currentUser['is_logged_in'] ?? false);
    $isAdmin    = (($currentUser['user_type'] ?? 'guest') === 'admin');

    // NAV FLAGS
    $showMemberMenu = $isLoggedIn && !$isAdmin;
    $showAdminMenu  = $isAdmin;

    // BODY CLASS
    $bodyClass = $isAdmin ? 'admin-layout' : ($isLoggedIn ? 'member-layout' : 'public-layout');

    // CURRENT PATH
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

    return compact('currentUser','isLoggedIn','isAdmin','showMemberMenu','showAdminMenu','bodyClass','currentPath');
}

// VALIDATE REQUIRED VIEW VARIABLES
function validate_layout_requirements($pageTitle, $contentView): void {
    if (empty($pageTitle)) {
        die('Error: Content controller must define $pageTitle');
    }
    if (empty($contentView) || !file_exists($contentView)) {
        die('Error: Content controller must define valid $contentView');
    }
}