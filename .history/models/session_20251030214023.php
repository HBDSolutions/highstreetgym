<?php

// SESSION MANAGEMENT FUNCTIONS

// Check user is logged in

function is_user_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

//  Get user data

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
    
    // Derive full name
    $firstName = $_SESSION['first_name'] ?? '';
    $lastName = $_SESSION['last_name'] ?? '';
    $fullName = trim($firstName . ' ' . $lastName);
    
    // Fallback to 'User' if name is empty
    if (empty($fullName)) {
        $fullName = 'User';
    }
    
    return [
        'is_logged_in' => true,
        'user_name' => $fullName,
        'user_type' => $_SESSION['user_type'] ?? 'member',
        'user_email' => $_SESSION['user_email'] ?? '',
        'user_id' => $_SESSION['user_id'] ?? null
    ];
}

// Check user permission

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

// Require user to be logged in

function require_login($redirectAfterLogin = '') {
    if (!is_user_logged_in()) {
        $redirect = $redirectAfterLogin ?: $_SERVER['REQUEST_URI'];
        header('Location: controllers/auth/login_controller.php?msg=login_required&redirect=' . urlencode($redirect));
        exit;
    }
}

// Require specific user type/permission

function require_permission($requiredType) {
    require_login(); // First ensure logged in
    
    if (!user_has_permission($requiredType)) {
        $_SESSION['error_message'] = 'You do not have permission to access this page.';
        header('Location: /highstreetgym/index.php');
        exit;
    }
}
?>