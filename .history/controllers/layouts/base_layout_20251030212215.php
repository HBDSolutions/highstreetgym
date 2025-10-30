<?php
/**
 * BASE LAYOUT INITIALISATION
 * 
 * LANGUAGE: Australian English (use 's' not 'z')
 * 
 * Shared functionality for all layout controllers
 * Returns initialisation data instead of using globals
 * 
 * USAGE: $layoutData = init_base_layout();
 */

/**
 * Initialise base layout requirements
 * Returns all common data needed by layout controllers
 * 
 * @return array Associative array with all layout data
 */
function init_base_layout() {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Include required models
    require_once __DIR__ . '/../../models/database.php';
    require_once __DIR__ . '/../../models/session.php';

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

/**
 * Navigation helper function
 * Determines if a navigation item should be marked as active
 * 
 * @param string $needle The path segment to check for
 * @return string 'active' if current path ends with needle, empty string otherwise
 */
function is_active($needle) {
    global $currentPath;
    return str_ends_with($currentPath, $needle) ? 'active' : '';
}

/**
 * Validate required view variables
 * Ensures content controller has set necessary variables
 * 
 * @param string $pageTitle The page title
 * @param string $contentView The content view path
 * @throws Exception if required variables are missing
 */
function validate_layout_requirements($pageTitle, $contentView) {
    if (empty($pageTitle)) {
        die('Error: Content controller must define $pageTitle');
    }
    
    if (empty($contentView) || !file_exists($contentView)) {
        die('Error: Content controller must define valid $contentView');
    }
}

?>