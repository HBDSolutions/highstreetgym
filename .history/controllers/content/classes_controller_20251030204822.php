<?php
/**
 * CLASSES CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Class schedule display and booking management
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include dependencies
require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/class_functions.php';

// Get authentication state
$currentUser = get_current_user_display();
$isLoggedIn = $currentUser['is_logged_in'];
$userId = $currentUser['user_id'];
$userType = $currentUser['user_type'];

// Initialise variables
$bookingMessage = '';
$bookingSuccess = false;

// Handle class booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'book') {
    if (!$isLoggedIn) {
        $bookingMessage = 'Please login to book classes';
        $bookingSuccess = false;
    } else {
        $scheduleId = intval($_POST['schedule_id'] ?? 0);
        
        if ($scheduleId > 0) {
            $result = book_class($conn, $scheduleId, $userId);
            $bookingMessage = $result['message'];
            $bookingSuccess = $result['success'];
            
            if ($bookingSuccess) {
                $_SESSION['booking_message'] = $bookingMessage;
                $_SESSION['booking_success'] = true;
                header('Location: /highstreetgym/controllers/content/classes_controller.php');
                exit;
            }
        } else {
            $bookingMessage = 'Invalid class selection';
            $bookingSuccess = false;
        }
    }
}

// Check for booking message from session
if (isset($_SESSION['booking_message'])) {
    $bookingMessage = $_SESSION['booking_message'];
    $bookingSuccess = $_SESSION['booking_success'] ?? false;
    unset($_SESSION['booking_message']);
    unset($_SESSION['booking_success']);
}

// Get weekly schedule from model
$weeklySchedule = get_weekly_schedule($conn);

// Organise schedule by day
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$scheduleByDay = [];

foreach ($days as $day) {
    $scheduleByDay[$day] = array_filter($weeklySchedule, function($class) use ($day) {
        return $class['day_of_week'] === $day;
    });
}

// CONTROLLER DECISIONS - Set flags for what to display
$canBookClasses = $isLoggedIn;
$showLoginPrompt = !$isLoggedIn;
$showBookingMessage = !empty($bookingMessage);
$showNoSchedule = empty($weeklySchedule);
$showSchedule = !empty($weeklySchedule);

// Define view variables
$pageTitle = 'Class Schedule';
$contentView = __DIR__ . '/../../views/content/classes.php';

// Load layout
require_once __DIR__ . '/../layouts/public_layout.php';
?>