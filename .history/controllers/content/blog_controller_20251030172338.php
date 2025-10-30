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

// Initialise HTML output variables
$messagesHTML = '';
$createFormHTML = '';
$postsHTML = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_post') {
    if (!$isLoggedIn) {
        $messagesHTML = '<p class="error">You must be logged in to create blog posts</p>';
    } else {
        $result = create_blog_post($conn, $userId, $_POST['title'] ?? '', $_POST['message'] ?? '');
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            header('Location: /highstreetgym/controllers/content/blog_controller.php');
            exit;
        } else {
            $messagesHTML = '<ul class="errors">';
            foreach ($result['errors'] as $error) {
                $messagesHTML .= '<li>' . htmlspecialchars($error) . '</li>';
            }
            $messagesHTML .= '</ul>';
        }
    }
}

// Check for success message
if (isset($_SESSION['success_message'])) {
    $messagesHTML = '<p class="success">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
    unset($_SESSION['success_message']);
}

// PREPARE CREATE FORM HTML (or login prompt)
if ($isLoggedIn) {
    $createFormHTML = '
        <section>
            <h2>Create Post</h2>
            <form method="POST" action="/highstreetgym/controllers/content/blog_controller.php">
                <input type="hidden" name="action" value="create_post">
                
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required minlength="5" maxlength="200">
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required minlength="10" maxlength="2000"></textarea>
                
                <button type="submit">Post Message</button>
            </form>
        </section>';
} else {
    $createFormHTML = '<p><a href="/highstreetgym/controllers/auth/login_controller.php">Login</a> or <a href="/highstreetgym/controllers/auth/register_controller.php">Register</a> to create posts.</p>';
}

// PREPARE POSTS HTML
$posts = get_all_blog_posts($conn);

if (empty($posts)) {
    $postsHTML = '<p>No blog posts yet. Be the first to share your experience!</p>';
} else {
    foreach ($posts as $post) {
        $postsHTML .= '<article>';
        $postsHTML .= '<h3>' . htmlspecialchars($post['title']) . '</h3>';
        $postsHTML .= '<p>Posted by <strong>' . htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) . '</strong>';
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