<?php
/**
 * BASE LAYOUT
 *  * Shared functionality for all layout controllers
 * 
 * USAGE: $layoutData = init_base_layout();
 */

/**
 * Returns all common data needed by layout controllers
 */

function init_base_layout() {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Include required models
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/session.php';
    require_once __DIR__ . '/../../models/navigation.php';

    // Get user authentication state
    $currentUser = get_current_user_display();
    
    // Prepare navigation path
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    
    // Login modal setup
    $modalLoginError = $_SESSION['modal_login_error'] ?? null;
    unset($_SESSION['modal_login_error']);
    
    $showModalLoginError = !empty($modalLoginError);
    
    $loginModalContext = [
        'showErrorAlert' => $showModalLoginError,
        'errorMessage' => $modalLoginError ?? '',
        'formAction' => '/highstreetgym/controllers/auth/login_controller.php'
    ];
    
    // Return all data as an associative array
    return [
        // User authentication
        'currentUser' => $currentUser,
        'isLoggedIn' => $currentUser['is_logged_in'],
        'userId' => $currentUser['user_id'],
        'userName' => $currentUser['user_name'],
        'userEmail' => $currentUser['user_email'],
        'userType' => $currentUser['user_type'],
        
        // Navigation
        'currentPath' => $currentPath,
        
        // Login modal
        'modalLoginError' => $modalLoginError,
        'showModalLoginError' => $showModalLoginError,
        'showLoginModal' => $showModalLoginError,
        'loginModalContext' => $loginModalContext
    ];
}

// Validate required view variables

function validate_layout_requirements($pageTitle, $contentView) {
    if (empty($pageTitle)) {
        die('Error: Content controller must define $pageTitle');
    }
    
    if (empty($contentView) || !file_exists($contentView)) {
        die('Error: Content controller must define valid $contentView');
    }
}

?>