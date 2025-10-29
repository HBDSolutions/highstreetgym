<?php

// CLASSES PAGE CONTROLLER

// Include base controller
require_once __DIR__ . '/basecontroller.php';
require_once __DIR__ . '/../models/class_functions.php';

// Flags
$bookingMessage = '';
$showBookingAlert = false;
$bookingSuccess = false;

// Handle booking actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $action = $_POST['action'] ?? '';
    $schedule_id = intval($_POST['schedule_id'] ?? 0);
    $booking_id = intval($_POST['booking_id'] ?? 0);
    
    if ($action === 'book' && $schedule_id > 0) {
        $result = book_class($conn, $schedule_id, $userId);
        $bookingMessage = $result['message'];
        $showBookingAlert = true;
        $bookingSuccess = $result['success'];
    } elseif ($action === 'cancel' && $booking_id > 0) {
        $result = cancel_booking($conn, $booking_id, $userId);
        $bookingMessage = $result['message'];
        $showBookingAlert = true;
        $bookingSuccess = $result['success'];
    }
}

// Get data from model
$weeklySchedule = get_weekly_schedule($conn);
$userBookings = $isLoggedIn ? get_user_bookings($conn, $userId) : [];

// Process data
$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$scheduleByDay = [];

// Get booked schedule IDs
$userBookingScheduleIds = [];
foreach ($userBookings as $booking) {
    if ($booking['status'] === 'confirmed') {
        $userBookingScheduleIds[$booking['schedule_id']] = $booking['booking_id'];
    }
}

// Process schedule data
foreach ($weeklySchedule as $class) {
    $day = $class['day_of_week'];
    
    // Calculate flags
    $spotsAvailable = $class['max_capacity'] - $class['current_bookings'];
    $isFull = $spotsAvailable <= 0;
    $isBooked = isset($userBookingScheduleIds[$class['schedule_id']]);
    $bookingId = $isBooked ? $userBookingScheduleIds[$class['schedule_id']] : null;
    $canBook = $isLoggedIn && !$isBooked && !$isFull;
    
    // Format time
    $formattedStartTime = date('g:i A', strtotime($class['start_time']));
    $formattedEndTime = date('g:i A', strtotime($class['end_time']));
    $formattedLevel = ucwords(str_replace('_', ' ', $class['difficulty_level']));
    
    // Add to schedule
    $scheduleByDay[$day][] = [
        'schedule_id' => $class['schedule_id'],
        'class_name' => $class['class_name'],
        'description' => $class['description'],
        'duration' => $class['duration'],
        'difficulty_level' => $formattedLevel,
        'trainer_name' => $class['trainer_first_name'] . ' ' . $class['trainer_last_name'],
        'start_time' => $formattedStartTime,
        'end_time' => $formattedEndTime,
        'max_capacity' => $class['max_capacity'],
        'spots_available' => $spotsAvailable,
        'is_full' => $isFull,
        'is_booked' => $isBooked,
        'booking_id' => $bookingId,
        'can_book' => $canBook,
        'show_login_button' => !$isLoggedIn,
        'show_book_button' => $canBook,
        'show_cancel_button' => $isBooked && $bookingId,
        'show_full_button' => $isFull && !$isBooked
    ];
}

// Prepare view variables
$title = 'Classes - High Street Gym';
$view = __DIR__ . '/../views/classes.php';

// Display template
include __DIR__ . '/../views/layouts/base.php';
?>