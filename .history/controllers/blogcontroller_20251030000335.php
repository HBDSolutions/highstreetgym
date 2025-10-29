<?php

// BLOG CONTROLLER

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../models/database.php';

// Include blog model functions
require_once __DIR__ . '/../models/blog_functions.php';

// Include auth controller for login checking
require_once __DIR__ . '/AuthController.php';

// Get all blog posts for display

function get_posts_for_display($limit = null) {
    global $conn;
    
    // Call model function
    return get_all_blog_posts($conn, $limit);
}

// Handle new blog post creation

function handle_create_post() {
    global $conn;
    
    // Must be logged in to post
    if (!is_logged_in()) {
        return [
            'success' => false,
            'message' => 'Please login to create a blog post',
            'errors' => ['auth' => 'Authentication required']
        ];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $title = $_POST['title'] ?? '';
        $message = $_POST['message'] ?? '';
        
        // Call model function (business logic happens here)
        $result = create_blog_post($conn, $userId, $title, $message);
        
        if ($result['success']) {
            // Post created successfully
            $_SESSION['success_message'] = $result['message'];
            header('Location: blog.php');
            exit;
        } else {
            // Post creation failed - return errors
            return $result;
        }
    }
    
    return null;
}

// Handle blog post update

function handle_update_post() {
    global $conn;
    
    // Must be logged in
    if (!is_logged_in()) {
        return [
            'success' => false,
            'message' => 'Please login to edit posts',
            'errors' => ['auth' => 'Authentication required']
        ];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        $title = $_POST['title'] ?? '';
        $message = $_POST['message'] ?? '';
        
        if (!$postId) {
            return [
                'success' => false,
                'message' => 'Invalid post selection',
                'errors' => ['post' => 'Post ID required']
            ];
        }
        
        // Call model function (business logic happens here)
        $result = update_blog_post($conn, $postId, $userId, $title, $message);
        
        if ($result['success']) {
            // Post updated successfully
            $_SESSION['success_message'] = $result['message'];
            header('Location: blog.php');
            exit;
        } else {
            // Update failed - return errors
            return $result;
        }
    }
    
    return null;
}

// Handle blog post deletion

function handle_delete_post() {
    global $conn;
    
    // Must be logged in
    if (!is_logged_in()) {
        return [
            'success' => false,
            'message' => 'Please login to delete posts'
        ];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            return [
                'success' => false,
                'message' => 'Invalid post selection'
            ];
        }
        
        // Call model function (business logic happens here)
        $result = delete_blog_post($conn, $postId, $userId);
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            header('Location: blog.php');
            exit;
        }
        
        return $result;
    }
    
    return [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}

// Get current user's posts

function get_current_user_posts() {
    global $conn;
    
    if (!is_logged_in()) {
        return [];
    }
    
    $userId = $_SESSION['user_id'];
    
    // Call model function
    return get_user_blog_posts($conn, $userId);
}

// Get single post for editing

function get_post_for_edit($postId) {
    global $conn;
    
    if (!is_logged_in()) {
        return null;
    }
    
    $post = get_blog_post_by_id($conn, $postId);
    
    // Verify user owns the post
    if ($post && $post['user_id'] == $_SESSION['user_id']) {
        return $post;
    }
    
    return null;
}
?>