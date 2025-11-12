<?php
// NAVIGATION MODEL
// PURPOSE: PROVIDES NAV STATE + ACTIVE-LINK HELPERS FOR VIEWS

// GET NAVIGATION DATA FOR VIEWS
function get_navigation_data(): array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // READ SESSION
    $isLoggedIn = !empty($_SESSION['logged_in']);
    $userType   = $isLoggedIn ? ($_SESSION['user_type'] ?? 'member') : 'guest';
    $userName   = $isLoggedIn
        ? trim(($_SESSION['first_name'] ?? '').' '.($_SESSION['last_name'] ?? ''))
        : 'Account';

    // FLAGS
    $isAdmin        = ($userType === 'admin');
    $showMemberMenu = $isLoggedIn;
    $showAdminMenu  = $isAdmin;

    // PATH FOR ACTIVE LINK
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

    // RETURN STRUCT
    return [
        'currentUser'    => ['user_name' => $userName, 'user_type' => $userType],
        'isLoggedIn'     => $isLoggedIn,
        'isAdmin'        => $isAdmin,
        'showMemberMenu' => $showMemberMenu,
        'showAdminMenu'  => $showAdminMenu,
        'currentPath'    => $currentPath,
    ];
}

// ACTIVE-LINK CHECK USING EXPLICIT PATH
function is_navigation_active(string $needle, string $currentPath): string {
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

// CANONICAL HELPER CALLED BY VIEWS/PARTIALS
if (!function_exists('nav_active')) {
    function nav_active(string $needle, ?string $currentPath = null): string {
        $path = $currentPath ?? (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
        return (str_ends_with($path, $needle)) ? 'active' : '';
    }
}