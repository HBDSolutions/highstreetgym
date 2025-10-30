<?php
/**
 * BLOG CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Data access, permissions, and view decisions
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
$successMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_post') {
    if (!$isLoggedIn) {
        $errors[] = 'You must be logged in to create blog posts';
    } else {
        $result = create_blog_post($conn, $userId, $_POST['title'] ?? '', $_POST['message'] ?? '');
        
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            header('Location: /highstreetgym/controllers/content/blog_controller.php');
            exit;
        } else {
            $errors = array_values($result['errors'] ?? []);
        }
    }
}

// Check for success message
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Get data from model
$posts = get_all_blog_posts($conn);

// CONTROLLER DECISIONS - Set flags for what to display
$showSuccessMessage = !empty($successMessage);
$showErrors = !empty($errors);
$showCreateForm = $isLoggedIn;
$showLoginPrompt = !$isLoggedIn;
$showPosts = !empty($posts);
$showNoPosts = empty($posts);

// Define view variables
$pageTitle = 'Member Blog';
$contentView = __DIR__ . '/../../views/content/blog.php';

// TEMPORARY DEBUG - Remove after testing
echo "Posts count: " . count($posts) . "<br>";
echo "showPosts: " . ($showPosts ? 'true' : 'false') . "<br>";
echo "showNoPosts: " . ($showNoPosts ? 'true' : 'false') . "<br>";
if (!empty($posts)) {
    echo "First post title: " . htmlspecialchars($posts[0]['title']) . "<br>";
}
die('Debug stop');

// Load layout
require_once __DIR__ . '/../layouts/public_layout.php';
?>