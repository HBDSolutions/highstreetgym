<?php
/**
 * BOOKINGS CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: User's booking management
 * - Displays user's active and cancelled bookings
 * - Handles booking cancellations
 * - Member-only page (uses member_layout)
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
$userName = $currentUser['user_name'];
$userEmail = $currentUser['user_email'];
$userType = $currentUser['user_type'];

// Initialise flags
$cancelMessage = '';
$showCancelAlert = false;
$cancelSuccess = false;

// Handle booking cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'cancel') {
        $bookingId = intval($_POST['booking_id'] ?? 0);
        
        if ($bookingId > 0) {
            // Call BUSINESS LOGIC in model
            $result = cancel_booking($conn, $bookingId, $userId);
            
            $cancelMessage = $result['message'];
            $showCancelAlert = true;
            $cancelSuccess = $result['success'];
        }
    }
}

// Get user's bookings from model
$userBookings = get_user_bookings($conn, $userId);

// Separate active and cancelled bookings
$activeBookings = [];
$cancelledBookings = [];

foreach ($userBookings as $booking) {
    if ($booking['status'] === 'confirmed') {
        // Format data for display
        $startTime = date('g:i A', strtotime($booking['start_time']));
        $endTime = date('g:i A', strtotime($booking['end_time']));
        $bookingDate = date('F j, Y', strtotime($booking['booking_date']));
        
        $activeBookings[] = [
            'booking_id' => $booking['booking_id'],
            'class_name' => $booking['class_name'],
            'description' => $booking['description'],
            'day_of_week' => $booking['day_of_week'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'trainer_name' => $booking['trainer_first_name'] . ' ' . $booking['trainer_last_name'],
            'booking_date' => $bookingDate,
            'status' => 'Confirmed'
        ];
    } else {
        $cancelledBookings[] = $booking;
    }
}

// Generate HTML for active bookings
$activeBookingsHTML = '';

if (count($activeBookings) > 0) {
    foreach ($activeBookings as $booking) {
        $activeBookingsHTML .= '<div class="col-md-6 col-lg-4">';
        $activeBookingsHTML .= '<div class="card h-100 border-success border-2">';
        $activeBookingsHTML .= '<div class="card-body">';
        
        // Class name with status badge
        $activeBookingsHTML .= '<h5 class="card-title">';
        $activeBookingsHTML .= htmlspecialchars($booking['class_name']);
        $activeBookingsHTML .= ' <span class="badge bg-success">Confirmed</span>';
        $activeBookingsHTML .= '</h5>';
        
        // Day and time
        $activeBookingsHTML .= '<p class="card-text mb-2">';
        $activeBookingsHTML .= '<strong>When:</strong> ' . htmlspecialchars($booking['day_of_week']);
        $activeBookingsHTML .= '</p>';
        
        $activeBookingsHTML .= '<p class="card-text text-muted mb-2">';
        $activeBookingsHTML .= '<strong>Time:</strong> ' . $booking['start_time'] . ' - ' . $booking['end_time'];
        $activeBookingsHTML .= '</p>';
        
        // Trainer
        $activeBookingsHTML .= '<p class="card-text mb-2">';
        $activeBookingsHTML .= '<strong>Trainer:</strong> ' . htmlspecialchars($booking['trainer_name']);
        $activeBookingsHTML .= '</p>';
        
        // Booked date
        $activeBookingsHTML .= '<p class="card-text small text-muted mb-3">';
        $activeBookingsHTML .= 'Booked on: ' . $booking['booking_date'];
        $activeBookingsHTML .= '</p>';
        
        // Description
        if ($booking['description']) {
            $activeBookingsHTML .= '<p class="card-text small mb-3">';
            $activeBookingsHTML .= htmlspecialchars($booking['description']);
            $activeBookingsHTML .= '</p>';
        }
        
        // Cancel button
        $activeBookingsHTML .= '<form method="POST" onsubmit="return confirm(\'Are you sure you want to cancel this booking?\')">';
        $activeBookingsHTML .= '<input type="hidden" name="action" value="cancel">';
        $activeBookingsHTML .= '<input type="hidden" name="booking_id" value="' . $booking['booking_id'] . '">';
        $activeBookingsHTML .= '<button type="submit" class="btn btn-outline-danger w-100">Cancel Booking</button>';
        $activeBookingsHTML .= '</form>';
        
        $activeBookingsHTML .= '</div>'; // card-body
        $activeBookingsHTML .= '</div>'; // card
        $activeBookingsHTML .= '</div>'; // col
    }
}

// Set flags for view
$hasActiveBookings = count($activeBookings) > 0;
$showNoBookingsMessage = !$hasActiveBookings;

// Define required view variables for layout controller
$pageTitle = 'My Bookings';
$contentView = __DIR__ . '/../../views/content/bookings.php';

// Load MEMBER layout controller (enforces authentication)
require_once __DIR__ . '/../layouts/member_layout.php';
?>