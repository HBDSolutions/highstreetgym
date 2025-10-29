<?php

// CLASSES CONTROLLER

// Include base controller
require_once __DIR__ . '/basecontroller.php';
require_once __DIR__ . '/../models/class_functions.php';

// Initialise flags
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

// Get user's booked schedule IDs
$userBookingScheduleIds = [];
foreach ($userBookings as $booking) {
    if ($booking['status'] === 'confirmed') {
        $userBookingScheduleIds[$booking['schedule_id']] = $booking['booking_id'];
    }
}

// Process schedule
$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$dayScheduleHTML = [];
$hasSchedule = false;

foreach ($daysOfWeek as $day) {
    $dayClasses = array_filter($weeklySchedule, function($class) use ($day) {
        return $class['day_of_week'] === $day;
    });
    
    if (empty($dayClasses)) {
        $dayScheduleHTML[$day] = '';
        continue;
    }
    
    $hasSchedule = true;
    $html = '<div class="card mb-4">';
    $html .= '<div class="card-header bg-primary text-white">';
    $html .= '<h3 class="mb-0">' . htmlspecialchars($day) . '</h3>';
    $html .= '</div>';
    $html .= '<div class="card-body">';
    $html .= '<div class="row g-3">';
    
    foreach ($dayClasses as $class) {
        // Calculate all flags and data
        $spotsAvailable = $class['max_capacity'] - $class['current_bookings'];
        $isFull = $spotsAvailable <= 0;
        $isBooked = isset($userBookingScheduleIds[$class['schedule_id']]);
        $bookingId = $isBooked ? $userBookingScheduleIds[$class['schedule_id']] : null;
        $canBook = $isLoggedIn && !$isBooked && !$isFull;
        
        // Format data
        $startTime = date('g:i A', strtotime($class['start_time']));
        $endTime = date('g:i A', strtotime($class['end_time']));
        $level = ucwords(str_replace('_', ' ', $class['difficulty_level']));
        $trainerName = htmlspecialchars($class['trainer_first_name'] . ' ' . $class['trainer_last_name']);
        $className = htmlspecialchars($class['class_name']);
        $description = htmlspecialchars($class['description']);
        
        // Build class card
        $borderClass = $isBooked ? 'border-success border-2' : '';
        $html .= '<div class="col-md-6 col-lg-4">';
        $html .= '<div class="card h-100 ' . $borderClass . '">';
        $html .= '<div class="card-body">';
        
        // Title
        $html .= '<h5 class="card-title">' . $className;
        if ($isBooked) {
            $html .= ' <span class="badge bg-success">Booked</span>';
        }
        $html .= '</h5>';
        
        // Time
        $html .= '<p class="card-text text-muted mb-2">';
        $html .= 'Time: ' . $startTime . ' - ' . $endTime;
        $html .= ' <span class="badge bg-secondary ms-1">' . $class['duration'] . ' min</span>';
        $html .= '</p>';
        
        // Trainer
        $html .= '<p class="card-text mb-2">';
        $html .= '<strong>Trainer:</strong> ' . $trainerName;
        $html .= '</p>';
        
        // Level
        $html .= '<p class="card-text mb-2">';
        $html .= '<strong>Level:</strong> ';
        $html .= '<span class="badge bg-info">' . $level . '</span>';
        $html .= '</p>';
        
        // Spots
        $html .= '<p class="card-text mb-3">';
        $html .= '<strong>Spots:</strong> ';
        if ($isFull) {
            $html .= '<span class="text-danger fw-bold">FULL</span>';
        } else {
            $html .= '<span class="text-success fw-bold">';
            $html .= $spotsAvailable . ' / ' . $class['max_capacity'] . ' available';
            $html .= '</span>';
        }
        $html .= '</p>';
        
        // Description
        if ($description) {
            $html .= '<p class="card-text small text-muted mb-3">' . $description . '</p>';
        }
        
        // Action buttons
        if ($canBook) {
            $html .= '<form method="POST">';
            $html .= '<input type="hidden" name="action" value="book">';
            $html .= '<input type="hidden" name="schedule_id" value="' . $class['schedule_id'] . '">';
            $html .= '<button type="submit" class="btn btn-primary w-100">Book Now</button>';
            $html .= '</form>';
        } elseif ($isBooked && $bookingId) {
            $html .= '<form method="POST" onsubmit="return confirm(\'Cancel this booking?\')">';
            $html .= '<input type="hidden" name="action" value="cancel">';
            $html .= '<input type="hidden" name="booking_id" value="' . $bookingId . '">';
            $html .= '<button type="submit" class="btn btn-outline-danger w-100">Cancel Booking</button>';
            $html .= '</form>';
        } elseif ($isFull) {
            $html .= '<button class="btn btn-secondary w-100" disabled>Class Full</button>';
        } elseif (!$isLoggedIn) {
            $html .= '<a href="login.php" class="btn btn-outline-primary w-100">Login to Book</a>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }
    
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    
    $dayScheduleHTML[$day] = $html;
}

// Set flags for view
$showLoginPrompt = !$isLoggedIn;
$showNoScheduleMessage = !$hasSchedule;

// Prepare view variables
$title = 'Classes - High Street Gym';
$view = __DIR__ . '/../views/classes.php';

// Display template
include __DIR__ . '/../views/layouts/base.php';
?>