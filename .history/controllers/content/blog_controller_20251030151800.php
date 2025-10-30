<?php
/**
 * BLOG CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Blog-specific data access, permissions, and view logic
 * - Handles blog post creation
 * - Manages data permissions (who can post/edit)
 * - Prepares data for view
 * - Uses member_layout for rendering
 */

// Include blog model (business logic)
require_once __DIR__ . '/../../models/blog_functions.php';

// Initialise view variables
$errors = [];
$success = '';
$posts = [];
$canCreatePost = false;
$canEditAll = false;

// NOTE: $conn, $isLoggedIn, $userId, $userType are provided by layout controller

// DATA ACCESS PERMISSION: Can this user create posts?
if ($isLoggedIn) {
    $canCreatePost = true;
}

// DATA ACCESS PERMISSION: Can this user edit all posts?
if ($userType === 'admin') {
    $canEditAll = true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'create_post') {
        // DATA PERMISSION CHECK
        if (!$canCreatePost) {
            $errors['auth'] = 'You must be logged in to create blog posts';
        } else {
            // Get form data
            $title = $_POST['title'] ?? '';
            $message = $_POST['message'] ?? '';
            
            // Call BUSINESS LOGIC in model
            $result = create_blog_post($conn, $userId, $title, $message);
            
            // VIEW LOGIC: Handle result
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
                header('Location: /highstreetgym/controllers/content/blog_controller.php');
                exit;
            } else {
                $errors = $result['errors'] ?? [];
            }
        }
    }
}

// Check for success message from session
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Get all blog posts using BUSINESS LOGIC from model
$posts = get_all_blog_posts($conn);

// VIEW LOGIC: Add permission flags to each post
foreach ($posts as &$post) {
    $post['can_edit'] = ($canEditAll || $post['user_id'] === $userId);
    $post['can_delete'] = ($canEditAll || $post['user_id'] === $userId);
}

// Define required view variables for layout controller
$pageTitle = 'Member Blog';
$contentView = __DIR__ . '/../../views/content/blog.php';

// Load layout controller (handles page-level permissions and rendering)
require_once __DIR__ . '/../layouts/public_layout.php';
?>