<?php

// NAVIGATION HELPER FUNCTIONS

/**
 * GET NAVIGATION DATA FOR VIEWS
 * RETURNS ALL DATA NEEDED TO RENDER NAVIGATION
 */
function get_navigation_data() {
    // GET CURRENT USER STATE
    $currentUser = get_current_user_display();
    
    $isLoggedIn = $currentUser['is_logged_in'];
    $userName = $currentUser['user_name'];
    $userType = $currentUser['user_type'];
    $isAdmin = ($userType === 'admin');
    
    // DETERMINE HOME URL BASED ON USER TYPE
    $homeHref = $isAdmin
        ? '/highstreetgym/controllers/content/admin_controller.php'
        : '/highstreetgym/controllers/content/home_controller.php';
    
    // DETERMINE WHAT MENUS TO SHOW
    $showMemberMenu = $isLoggedIn;
    $showAdminMenu = $isAdmin;
    $showLoginButton = !$isLoggedIn;
    
    // PREPARE CURRENT PATH FOR ACTIVE LINK DETECTION
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    
    // PREPARE LOGIN MODAL DATA
    $modalLoginError = $_SESSION['modal_login_error'] ?? null;
    unset($_SESSION['modal_login_error']);
    $showLoginModal = !empty($modalLoginError);
    
    $loginModalContext = [
        'showErrorAlert' => $showLoginModal,
        'errorMessage' => $modalLoginError ?? '',
        'formAction' => '/highstreetgym/controllers/auth/login_controller.php',
        'showSuccessAlert' => false,
        'showInfoAlert' => false,
        'infoMessage' => '',
        'successMessageText' => '',
        'showCardWrapper' => false,
        'showRegisterLink' => false,
        'previousEmail' => '',
        'redirectUrl' => ''
    ];
    
    return [
        'isLoggedIn' => $isLoggedIn,
        'userName' => $userName,
        'userType' => $userType,
        'isAdmin' => $isAdmin,
        'homeHref' => $homeHref,
        'showMemberMenu' => $showMemberMenu,
        'showAdminMenu' => $showAdminMenu,
        'showLoginButton' => $showLoginButton,
        'currentPath' => $currentPath,
        'showLoginModal' => $showLoginModal,
        'loginModalContext' => $loginModalContext
    ];
}

/**
 * CHECK IF NAVIGATION LINK IS ACTIVE
 */
function is_navigation_active($needle, $currentPath) {
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

if (!function_exists('nav_active')) {
    function nav_active(string $needle): string {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        return is_navigation_active($needle, $path);
    }
}

?>