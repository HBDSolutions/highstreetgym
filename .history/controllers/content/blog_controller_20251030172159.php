<?php
/**
 * BLOG CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Blog-specific data access, permissions, and view logic
 * - Handles blog post creation
 * - Manages data permissions (who can post/edit)
 * - Prepares data for view
 * - Uses public_layout for rendering
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/blog_functions.php';

// Get authentication state
$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];
$userId = $currentUser['user_id'];
$userType = $currentUser['user_type'];

// Initialise variables
$errors = [];
$success = '';
$showCreateForm = $isLoggedIn;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_post') {
    if (!$isLoggedIn) {
        $errors['auth'] = 'You must be logged in to create blog posts';
    } else {
        $result = create_blog_post($conn, $userId, $_POST['title'] ?? '', $_POST['message'] ?? '');
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            header('Location: /highstreetgym/controllers/content/blog_controller.php');
            exit;
        } else {
            $errors = $result['errors'] ?? [];
        }
    }
}

// Check for success message
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Get all blog posts
$posts = get_all_blog_posts($conn);

// CONTROLLER PREPARES ALL DISPLAY LOGIC
$postsHTML = '';
if (empty($posts)) {
    $postsHTML = '<p>No blog posts yet. Be the first to share your experience!</p>';
} else {
    foreach ($posts as $post) {
        $postsHTML .= '<article>';
        $postsHTML .= '<h3>' . htmlspecialchars($post['title']) . '</h3>';
        $postsHTML .= '<p>Posted by ' . htmlspecialchars($post['first_name'] . ' ' . $post['last_name']);
        $postsHTML .= ' on ' . date('F j, Y', strtotime($post['post_date'])) . '</p>';
        $postsHTML .= '<p>' . nl2br(htmlspecialchars($post['message'])) . '</p>';
        $postsHTML .= '</article>';
    }
}

// Define view variables
$pageTitle = 'Member Blog';
$contentView = __DIR__ . '/../../views/content/blog.php';

// Load layout
require_once __DIR__ . '/../layouts/public_layout.php';
?>