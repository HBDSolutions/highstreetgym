<?php

// SESSION MANAGEMENT FUNCTIONS

// Check if user is currently logged in

function is_user_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Get current user data for display purposes

function get_current_user_display() {
    if (!is_user_logged_in()) {
        return [
            'is_logged_in' => false,
            'user_name' => 'Guest',
            'user_type' => null,
            'user_email' => null,
            'user_id' => null
        ];
    }
    
    return [
        'is_logged_in' => true,
        'user_name' => $_SESSION['user_name'] ?? 'User',
        'user_type' => $_SESSION['user_type'] ?? 'member',
        'user_email' => $_SESSION['user_email'] ?? '',
        'user_id' => $_SESSION['user_id'] ?? null
    ];

    // Check if current user has specific permission

function user_has_permission($requiredType) {
    if (!is_user_logged_in()) {
        return false;
    }
    
    $userType = $_SESSION['user_type'] ?? 'member';
    
    // Admin has all permissions
    if ($userType === 'admin') {
        return true;
    }
    
    // Check specific permission
    return $userType === $requiredType;
}

// User must be logged in

function require_login($redirectAfterLogin = '') {
    if (!is_user_logged_in()) {
        $redirect = $redirectAfterLogin ?: $_SERVER['REQUEST_URI'];
        header('Location: controllers/login.php?msg=login_required&redirect=' . urlencode($redirect));
        exit;
    }
}

// Require specific user type/permission

function require_permission($requiredType) {
    require_login();
    
    if (!user_has_permission($requiredType)) {
        $_SESSION['error_message'] = 'You do not have permission to access this page.';
        header('Location: ../index.php');
        exit;
    }
}
?>