<?php

// CLASSES PAGE CONTROLLER

// Include base controller (sets up session, user state, common variables)
require_once __DIR__ . '/basecontroller.php';
require_once __DIR__ . '/../models/class_functions.php';

// Initialize variables
$bookingMessage = '';
$showBookingAlert = false;
$bookingSuccess = false;

// Handle booking actions (POST)
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

// Get weekly schedule
$weeklySchedule = get_weekly_schedule($conn);

// Organize schedule by day
$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$scheduleByDay = [];

foreach ($daysOfWeek as $day) {
    $scheduleByDay[$day] = array_filter($weeklySchedule, function($class) use ($day) {
        return $class['day_of_week'] === $day;
    });
}

// Get user's existing bookings if logged in
$userBookings = [];
$userBookingScheduleIds = [];

if ($isLoggedIn) {
    $userBookings = get_user_bookings($conn, $userId);
    
    // Create array of schedule IDs for easy lookup
    foreach ($userBookings as $booking) {
        if ($booking['status'] === 'confirmed') {
            $userBookingScheduleIds[] = $booking['schedule_id'];
        }
    }
}

// Calculate available spots for each class
foreach ($scheduleByDay as $day => $classes) {
    foreach ($classes as $index => $class) {
        $spotsAvailable = $class['max_capacity'] - $class['current_bookings'];
        $scheduleByDay[$day][$index]['spots_available'] = $spotsAvailable;
        $scheduleByDay[$day][$index]['is_full'] = $spotsAvailable <= 0;
        $scheduleByDay[$day][$index]['is_booked'] = in_array($class['schedule_id'], $userBookingScheduleIds);
    }
}

// Set up view context
$classesContext = [
    'scheduleByDay' => $scheduleByDay,
    'userBookings' => $userBookings,
    'isLoggedIn' => $isLoggedIn,
    'showBookingAlert' => $showBookingAlert,
    'bookingMessage' => $bookingMessage,
    'bookingSuccess' => $bookingSuccess,
    'daysOfWeek' => $daysOfWeek
];

// Prepare view variables
$title = 'Classes - High Street Gym';
$view = __DIR__ . '/../views/classes.php';

// Display template
include __DIR__ . '/../views/layouts/base.php';
?>