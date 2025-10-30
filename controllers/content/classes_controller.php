<?php
/**
 * CLASSES CONTENT CONTROLLER
 * 
 * RESPONSIBILITY: Class schedule display and booking management
 * - Shows weekly class schedule
 * - Handles class bookings
 * - Manages data permissions (who can book)
 * - Uses public_layout for rendering
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

// Initialise variables
$bookingMessage = '';
$showBookingAlert = false;
$bookingSuccess = false;
$showLoginPrompt = !$isLoggedIn;

// DATA ACCESS PERMISSION: Can this user book classes?
$canBookClasses = $isLoggedIn;

// Handle class booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'book') {
        // DATA PERMISSION CHECK
        if (!$canBookClasses) {
            $bookingMessage = 'Please login to book classes';
            $showBookingAlert = true;
            $bookingSuccess = false;
        } else {
            $scheduleId = intval($_POST['schedule_id'] ?? 0);
            
            if ($scheduleId > 0) {
                // Call BUSINESS LOGIC in model
                $result = book_class($conn, $scheduleId, $userId);
                
                $bookingMessage = $result['message'];
                $showBookingAlert = true;
                $bookingSuccess = $result['success'];
                
                // If successful, redirect to prevent form resubmission
                if ($bookingSuccess) {
                    $_SESSION['booking_message'] = $bookingMessage;
                    $_SESSION['booking_success'] = true;
                    header('Location: /highstreetgym/controllers/content/classes_controller.php');
                    exit;
                }
            } else {
                $bookingMessage = 'Invalid class selection';
                $showBookingAlert = true;
                $bookingSuccess = false;
            }
        }
    }
}

// Check for booking message from session (after redirect)
if (isset($_SESSION['booking_message'])) {
    $bookingMessage = $_SESSION['booking_message'];
    $showBookingAlert = true;
    $bookingSuccess = $_SESSION['booking_success'] ?? false;
    unset($_SESSION['booking_message']);
    unset($_SESSION['booking_success']);
}

// Get weekly schedule from model
$weeklySchedule = get_weekly_schedule($conn);

// Organise schedule by day
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$dayScheduleHTML = [];
$showNoScheduleMessage = empty($weeklySchedule);

foreach ($days as $day) {
    $dayClasses = array_filter($weeklySchedule, function($class) use ($day) {
        return $class['day_of_week'] === $day;
    });
    
    if (!empty($dayClasses)) {
        $html = '<div class="mb-4">';
        $html .= '<h3 class="border-bottom pb-2">' . htmlspecialchars($day) . '</h3>';
        $html .= '<div class="row g-3">';
        
        foreach ($dayClasses as $class) {
            $startTime = date('g:i A', strtotime($class['start_time']));
            $endTime = date('g:i A', strtotime($class['end_time']));
            $trainerName = htmlspecialchars($class['trainer_first_name'] . ' ' . $class['trainer_last_name']);
            
            $html .= '<div class="col-md-6 col-lg-4">';
            $html .= '<div class="card h-100">';
            $html .= '<div class="card-body">';
            $html .= '<h5 class="card-title text-success">' . htmlspecialchars($class['class_name']) . '</h5>';
            $html .= '<p class="card-text"><small class="text-muted">' . $startTime . ' - ' . $endTime . '</small></p>';
            $html .= '<p class="card-text">' . htmlspecialchars($class['description']) . '</p>';
            $html .= '<p class="card-text"><strong>Trainer:</strong> ' . $trainerName . '</p>';
            
            if ($canBookClasses) {
                $html .= '<form method="POST" class="mt-3">';
                $html .= '<input type="hidden" name="action" value="book">';
                $html .= '<input type="hidden" name="schedule_id" value="' . $class['schedule_id'] . '">';
                $html .= '<button type="submit" class="btn btn-success w-100">';
                $html .= '<i class="bi bi-calendar-plus"></i> Book Class';
                $html .= '</button>';
                $html .= '</form>';
            }
            
            $html .= '</div>'; // card-body
            $html .= '</div>'; // card
            $html .= '</div>'; // col
        }
        
        $html .= '</div>'; // row
        $html .= '</div>'; // day container
        
        $dayScheduleHTML[$day] = $html;
    } else {
        $dayScheduleHTML[$day] = '';
    }
}

// Define required view variables for layout controller
$pageTitle = 'Class Schedule';
$contentView = __DIR__ . '/../../views/content/classes.php';

// Load layout controller (handles rendering)
require_once __DIR__ . '/../layouts/public_layout.php';
?>