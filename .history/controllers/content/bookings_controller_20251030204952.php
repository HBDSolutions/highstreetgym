<?php
/**
 * BOOKINGS CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: User's booking management
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
$cancelMessage = '';
$cancelSuccess = false;

// Handle booking cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $bookingId = intval($_POST['booking_id'] ?? 0);
    
    if ($bookingId > 0) {
        $result = cancel_booking($conn, $bookingId, $userId);
        $cancelMessage = $result['message'];
        $cancelSuccess = $result['success'];
    }
}

// Get user's bookings from model
$userBookings = get_user_bookings($conn, $userId);

// Separate and format active bookings
$activeBookings = [];

foreach ($userBookings as $booking) {
    if ($booking['status'] === 'confirmed') {
        $activeBookings[] = [
            'booking_id' => $booking['booking_id'],
            'class_name' => $booking['class_name'],
            'description' => $booking['description'],
            'day_of_week' => $booking['day_of_week'],
            'start_time' => date('g:i A', strtotime($booking['start_time'])),
            'end_time' => date('g:i A', strtotime($booking['end_time'])),
            'trainer_name' => $booking['trainer_first_name'] . ' ' . $booking['trainer_last_name'],
            'booking_date' => date('F j, Y', strtotime($booking['booking_date']))
        ];
    }
}

// CONTROLLER DECISIONS - Set flags for what to display
$showCancelMessage = !empty($cancelMessage);
$hasActiveBookings = !empty($activeBookings);
$showNoBookings = empty($activeBookings);

// Define view variables
$pageTitle = 'My Bookings';
$contentView = __DIR__ . '/../../views/content/bookings.php';

// Load MEMBER layout controller (enforces authentication)
require_once __DIR__ . '/../layouts/member_layout.php';
?>