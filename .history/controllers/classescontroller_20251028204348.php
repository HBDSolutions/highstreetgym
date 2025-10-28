<?php

// CLASSES CONTROLLER
// Connects class views with class functions

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../models/database.php';

// Include class model functions
require_once __DIR__ . '/../models/class_functions.php';

// Include auth controller for login checking
require_once __DIR__ . '/AuthController.php';

// Get weekly schedule for display

function get_schedule_for_display() {
    global $conn;
    
    // Call model function
    return get_weekly_schedule($conn);
}

// Get schedule organized by day

function get_schedule_by_day_for_display() {
    global $conn;
    
    $schedule = get_weekly_schedule($conn);
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    
    $organized = [];
    foreach ($days as $day) {
        $organized[$day] = array_filter($schedule, function($class) use ($day) {
            return $class['day_of_week'] === $day;
        });
    }
    
    return $organized;
}

// Handle class booking

function handle_book_class() {
    global $conn;
    
    // Must be logged in to book
    if (!is_logged_in()) {
        return [
            'success' => false,
            'message' => 'Please login to book a class'
        ];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $scheduleId = $_POST['schedule_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$scheduleId) {
            return [
                'success' => false,
                'message' => 'Invalid class selection'
            ];
        }
        
        // Call class booking function
        $result = book_class($conn, $scheduleId, $userId);
        
        return $result;
    }
    
    return [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}

// Handle booking cancellation

function handle_cancel_booking() {
    global $conn;
    
    // Must be logged in
    if (!is_logged_in()) {
        return [
            'success' => false,
            'message' => 'Please login to cancel bookings'
        ];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookingId = $_POST['booking_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$bookingId) {
            return [
                'success' => false,
                'message' => 'Invalid booking selection'
            ];
        }
        
        // Call model function (business logic happens here)
        $result = cancel_booking($conn, $bookingId, $userId);
        
        return $result;
    }
    
    return [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}

// Get current user's bookings

function get_current_user_bookings() {
    global $conn;
    
    if (!is_logged_in()) {
        return [];
    }
    
    $userId = $_SESSION['user_id'];
    
    // Call model function
    return get_user_bookings($conn, $userId);
}

// Handle AJAX booking request

function handle_ajax_booking() {
    header('Content-Type: application/json');
    
    $result = handle_book_class();
    echo json_encode($result);
    exit;
}

// Handle AJAX cancellation request

function handle_ajax_cancellation() {
    header('Content-Type: application/json');
    
    $result = handle_cancel_booking();
    echo json_encode($result);
    exit;
}
?>