<?php
// BASE LAYOUT BOOTSTRAP

function init_base_layout(): array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // INCLUDE MODELS NEEDED BY LAYOUTS
    require_once __DIR__ . '/../../models/session.php';
    require_once __DIR__ . '/../../models/navigation.php';
    require_once __DIR__ . '/../../models/database.php';

    // CURRENT USER
    $currentUser = get_current_user_display();
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

    // NAV FLAGS
    $isLoggedIn     = (bool)($currentUser['is_logged_in'] ?? false);
    $isAdmin        = ($currentUser['user_type'] ?? '') === 'admin';
    $showMemberMenu = $isLoggedIn;
    $showAdminMenu  = $isAdmin;

    // BODY CLASS
    $bodyClass = ($isAdmin ? 'admin-layout' : ($isLoggedIn ? 'member-layout' : 'public-layout'));

    return compact(
        'currentUser',
        'currentPath',
        'isLoggedIn',
        'isAdmin',
        'showMemberMenu',
        'showAdminMenu',
        'bodyClass'
    );
}

// LAYOUT INVARIANTS: VALIDATE REQUIRED VARS
function validate_layout_requirements(string $pageTitle, string $contentView): void {
    if ($pageTitle === '') {
        http_response_code(500);
        exit('LAYOUT ERROR: MISSING $pageTitle');
    }
    if (!is_file($contentView)) {
        http_response_code(500);
        exit('LAYOUT ERROR: MISSING/INVALID $contentView: ' . $contentView);
    }
}