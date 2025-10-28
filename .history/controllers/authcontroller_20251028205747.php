<?php

// AUTHENTICATION CONTROLLER
// Connects auth views with user functions

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../models/database.php';

// Include user model functions
require_once __DIR__ . '/../models/user_functions.php';

// Handle user registration

function handle_registration() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'phone' => $_POST['phone'] ?? ''
        ];
        
        // Call register user function
        $result = register_user($conn, $data);
        
        if ($result['success']) {
            // Registration successful - redirect to login
            $_SESSION['success_message'] = $result['message'];
            header('Location: login.php');
            exit;
        } else {
            // Registration failed - return errors to view
            return $result;
        }
    }
    
    return null;
}

// Handle user login

function handle_login() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Call user login function
        $result = login_user($conn, $email, $password);
        
        if ($result['success']) {
            // Login successful - set session variables
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['user_email'] = $result['user']['email'];
            $_SESSION['user_name'] = $result['user']['first_name'] . ' ' . $result['user']['last_name'];
            $_SESSION['user_type'] = $result['user']['user_type'];
            $_SESSION['logged_in'] = true;
            
            // Redirect to appropriate page
            if (isset($_POST['redirect']) && !empty($_POST['redirect'])) {
                header('Location: ' . $_POST['redirect']);
            } else {
                header('Location: ../index.php');
            }
            exit;
        } else {
            // Login failed - return errors to view
            return $result;
        }
    }
    
    return null;
}

// Handle user logout

function handle_logout() {
    // Destroy all session data
    session_destroy();
    
    // Clear session variables
    $_SESSION = [];
    
    // Redirect to home page
    header('Location: ../index.php');
    exit;
}

// Check if user is logged in

function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Require login - redirect to login page if not authenticated

function require_login($redirectUrl = null) {
    if (!is_logged_in()) {
        $redirect = $redirectUrl ?? $_SERVER['REQUEST_URI'];
        header('Location: auth/login.php?redirect=' . urlencode($redirect));
        exit;
    }
}

// Get current logged in user data

function get_current_user() {
    global $conn;
    
    if (!is_logged_in()) {
        return null;
    }
    
    // Get user data by ID
    return get_user_by_id($conn, $_SESSION['user_id']);
}
?>