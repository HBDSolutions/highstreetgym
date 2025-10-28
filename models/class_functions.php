<?php

// CLASS MANAGEMENT FUNCTIONS


// Get weekly schedule

function get_weekly_schedule($conn) {
    try {
        $sql = "SELECT 
                    s.schedule_id,
                    s.day_of_week,
                    s.start_time,
                    s.end_time,
                    s.max_capacity,
                    c.class_id,
                    c.class_name,
                    c.description,
                    c.duration,
                    c.difficulty_level,
                    t.trainer_id,
                    t.first_name AS trainer_first_name,
                    t.last_name AS trainer_last_name,
                    t.specialization,
                    (SELECT COUNT(*) FROM bookings WHERE schedule_id = s.schedule_id) AS current_bookings
                FROM schedules s
                INNER JOIN classes c ON s.class_id = c.class_id
                INNER JOIN trainers t ON s.trainer_id = t.trainer_id
                ORDER BY 
                    FIELD(s.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                    s.start_time";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $schedule;
        
    } catch (PDOException $e) {
        return [];
    }
}

// Get schedule by day of week

function get_schedule_by_day($conn, $dayOfWeek) {
    try {
        $sql = "SELECT 
                    s.schedule_id,
                    s.day_of_week,
                    s.start_time,
                    s.end_time,
                    s.max_capacity,
                    c.class_id,
                    c.class_name,
                    c.description,
                    c.duration,
                    c.difficulty_level,
                    t.trainer_id,
                    t.first_name AS trainer_first_name,
                    t.last_name AS trainer_last_name,
                    t.specialization,
                    (SELECT COUNT(*) FROM bookings WHERE schedule_id = s.schedule_id) AS current_bookings
                FROM schedules s
                INNER JOIN classes c ON s.class_id = c.class_id
                INNER JOIN trainers t ON s.trainer_id = t.trainer_id
                WHERE s.day_of_week = :day_of_week
                ORDER BY s.start_time";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':day_of_week', $dayOfWeek);
        $stmt->execute();
        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $schedule;
        
    } catch (PDOException $e) {
        return [];
    }
}

// Book a class for a user

function book_class($conn, $scheduleId, $userId) {
    
    // Check if user already has a booking for this schedule
    if (has_existing_booking($conn, $scheduleId, $userId)) {
        return [
            'success' => false,
            'message' => 'You have already booked this class'
        ];
    }
    
    // Check if class has availability
    if (is_class_full($conn, $scheduleId)) {
        return [
            'success' => false,
            'message' => 'This class is fully booked'
        ];
    }
    
    // Create the booking
    try {
        $sql = "INSERT INTO bookings (user_id, schedule_id, status) 
                VALUES (:user_id, :schedule_id, 'confirmed')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':schedule_id', $scheduleId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        
        return [
            'success' => true,
            'message' => 'Class booked successfully',
            'booking_id' => $conn->lastInsertId()
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Booking failed. Please try again.'
        ];
    }
}

// Cancel a booking

function cancel_booking($conn, $bookingId, $userId) {
    try {
        // Verify booking belongs to user
        $sql = "SELECT booking_id FROM bookings 
                WHERE booking_id = :booking_id AND user_id = :user_id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        if (!$booking) {
            return [
                'success' => false,
                'message' => 'Booking not found or access denied'
            ];
        }
        
        // Update booking status to cancelled
        $sql = "UPDATE bookings SET status = 'cancelled' 
                WHERE booking_id = :booking_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':booking_id', $bookingId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        
        return [
            'success' => true,
            'message' => 'Booking cancelled successfully'
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Cancellation failed. Please try again.'
        ];
    }
}

// Get user's bookings

function get_user_bookings($conn, $userId) {
    try {
        $sql = "SELECT 
                    b.booking_id,
                    b.booking_date,
                    b.status,
                    s.schedule_id,
                    s.day_of_week,
                    s.start_time,
                    s.end_time,
                    c.class_name,
                    c.description,
                    t.first_name AS trainer_first_name,
                    t.last_name AS trainer_last_name
                FROM bookings b
                INNER JOIN schedules s ON b.schedule_id = s.schedule_id
                INNER JOIN classes c ON s.class_id = c.class_id
                INNER JOIN trainers t ON s.trainer_id = t.trainer_id
                WHERE b.user_id = :user_id
                ORDER BY 
                    FIELD(s.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                    s.start_time";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $bookings;
        
    } catch (PDOException $e) {
        return [];
    }
}

// Check if user already has a schedule booking

function has_existing_booking($conn, $scheduleId, $userId) {
    try {
        $sql = "SELECT COUNT(*) FROM bookings 
                WHERE schedule_id = :schedule_id 
                AND user_id = :user_id 
                AND status = 'confirmed'";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':schedule_id', $scheduleId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        $stmt->closeCursor();
        
        return $count > 0;
        
    } catch (PDOException $e) {
        return false;
    }
}

// Check if class has availability

function is_class_full($conn, $scheduleId) {
    try {
        $sql = "SELECT 
                    s.max_capacity,
                    (SELECT COUNT(*) FROM bookings WHERE schedule_id = s.schedule_id AND status = 'confirmed') AS current_bookings
                FROM schedules s
                WHERE s.schedule_id = :schedule_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':schedule_id', $scheduleId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        if (!$result) {
            return true;
        }
        
        return $result['current_bookings'] >= $result['max_capacity'];
        
    } catch (PDOException $e) {
        return true;
    }
}

// Get all available classes of same type

function get_all_classes($conn) {
    try {
        $sql = "SELECT * FROM classes ORDER BY class_name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $classes;
        
    } catch (PDOException $e) {
        return [];
    }
}
?>