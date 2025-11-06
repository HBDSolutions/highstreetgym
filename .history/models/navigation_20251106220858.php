<?php
// NAVIGATION MODEL
// PURPOSE: PROVIDES NAV STATE + ACTIVE-LINK HELPERS FOR VIEWS

// GET NAVIGATION DATA FOR VIEWS
function get_navigation_data(): array {
    // USER STATE
    $currentUser  = get_current_user_display(); // from session.php
    $isLoggedIn   = $currentUser['is_logged_in'] ?? false;
    $userName     = $currentUser['user_name']    ?? '';
    $userType     = $currentUser['user_type']    ?? 'guest';
    $isAdmin      = ($userType === 'admin');

    // FLAGS
    $showMemberMenu  = $isLoggedIn;
    $showAdminMenu   = $isAdmin;
    $showLoginButton = !$isLoggedIn;

    // CURRENT PATH FOR ACTIVE-LINK DETECTION
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

    // LOGIN MODAL CONTEXT
    $modalLoginError = $_SESSION['modal_login_error'] ?? null;
    unset($_SESSION['modal_login_error']);
    $showLoginModal = !empty($modalLoginError);

    $loginModalContext = [
        'showErrorAlert' => $showLoginModal,
        'errorMessage'   => $modalLoginError ?? '',
        'formAction'     => '/highstreetgym/controllers/content/auth/login_controller.php'
    ];

    return [
        'isLoggedIn'       => $isLoggedIn,
        'userName'         => $userName,
        'userType'         => $userType,
        'isAdmin'          => $isAdmin,
        'showMemberMenu'   => $showMemberMenu,
        'showAdminMenu'    => $showAdminMenu,
        'showLoginButton'  => $showLoginButton,
        'currentPath'      => $currentPath,
        'showLoginModal'   => $showLoginModal,
        'loginModalContext'=> $loginModalContext
    ];
}

// ACTIVE-LINK CHECK USING EXPLICIT PATH
function is_navigation_active(string $needle, string $currentPath): string {
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

// CANONICAL HELPER CALLED BY VIEWS/PARTIALS
function nav_active(string $needle, ?string $currentPath = null): string {
    $path = $currentPath ?? (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '');
    return is_navigation_active($needle, $path);
}