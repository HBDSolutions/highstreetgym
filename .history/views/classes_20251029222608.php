<?php
// CLASSES VIEW - DUMB VIEW
// Expects $classesContext array

// Extract context
$weeklySchedule = $classesContext['weeklySchedule'] ?? [];
$userBookings = $classesContext['userBookings'] ?? [];
$isLoggedIn = $classesContext['isLoggedIn'] ?? false;
$showBookingAlert = $classesContext['showBookingAlert'] ?? false;
$bookingMessage = $classesContext['bookingMessage'] ?? '';
$bookingSuccess = $classesContext['bookingSuccess'] ?? false;

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
?>

<div class="container my-4">
    <h1 class="mb-4"><i class="bi bi-calendar-week"></i> Class Schedule</h1>
    
    <?php if (!$isLoggedIn): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> 
            <a href="login.php" class="alert-link">Login</a> or 
            <a href="register.php" class="alert-link">Register</a> to book classes
        </div>
    <?php endif; ?>
    
    <!-- Booking Alert -->
    <?php if ($showBookingAlert): ?>
        <div class="alert alert-<?= $bookingSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
            <i class="bi bi-<?= $bookingSuccess ? 'check-circle' : 'exclamation-triangle' ?>"></i>
            <?= htmlspecialchars($bookingMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Weekly Schedule -->
    <?php foreach ($daysOfWeek as $day): ?>
        <?php if (isset($weeklySchedule[$day]) && count($weeklySchedule[$day]) > 0): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><?= $day ?></h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php foreach ($weeklySchedule[$day] as $class): ?>
                            <?php 
                            $isBooked = in_array($class['schedule_id'], $userBookings);
                            $isFull = $class['is_full'];
                            $canBook = $isLoggedIn && !$isBooked && !$isFull;
                            ?>
                            
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 <?= $isBooked ? 'border-success' : '' ?>">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($class['class_name']) ?>
                                            <?php if ($isBooked): ?>
                                                <span class="badge bg-success">Booked</span>
                                            <?php endif; ?>
                                        </h5>
                                        
                                        <p class="card-text text-muted mb-2">
                                            <i class="bi bi-clock"></i>
                                            <?= date('g:i A', strtotime($class['start_time'])) ?> - 
                                            <?= date('g:i A', strtotime($class['end_time'])) ?>
                                            <span class="badge bg-secondary"><?= $class['duration'] ?> min</span>
                                        </p>
                                        
                                        <p class="card-text mb-2">
                                            <i class="bi bi-person-badge"></i>
                                            <strong>Trainer:</strong> 
                                            <?= htmlspecialchars($class['trainer_first_name'] . ' ' . $class['trainer_last_name']) ?>
                                        </p>
                                        
                                        <p class="card-text mb-2">
                                            <i class="bi bi-signal"></i>
                                            <strong>Level:</strong> 
                                            <span class="badge bg-info"><?= ucfirst($class['difficulty_level']) ?></span>
                                        </p>
                                        
                                        <p class="card-text mb-3">
                                            <i class="bi bi-people"></i>
                                            <strong>Spots:</strong> 
                                            <?php if ($isFull): ?>
                                                <span class="text-danger">FULL</span>
                                            <?php else: ?>
                                                <?= $class['spots_available'] ?> / <?= $class['max_capacity'] ?> available
                                            <?php endif; ?>
                                        </p>
                                        
                                        <?php if ($class['description']): ?>
                                            <p class="card-text small text-muted">
                                                <?= htmlspecialchars($class['description']) ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <!-- Action Buttons -->
                                        <?php if ($canBook): ?>
                                            <form method="POST" action="classes.php" class="d-inline">
                                                <input type="hidden" name="action" value="book">
                                                <input type="hidden" name="schedule_id" value="<?= $class['schedule_id'] ?>">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-calendar-plus"></i> Book Now
                                                </button>
                                            </form>
                                        <?php elseif ($isBooked): ?>
                                            <form method="POST" action="classes.php" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                <input type="hidden" name="action" value="cancel">
                                                <input type="hidden" name="schedule_id" value="<?= $class['schedule_id'] ?>">
                                                <button type="submit" class="btn btn-outline-danger w-100">
                                                    <i class="bi bi-x-circle"></i> Cancel Booking
                                                </button>
                                            </form>
                                        <?php elseif ($isFull): ?>
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="bi bi-x-circle"></i> Class Full
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    
    <?php if (empty($weeklySchedule)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            No classes scheduled at this time. Please check back later!
        </div>
    <?php endif; ?>
</div>

<!-- Client-side booking confirmation (already handled by onsubmit for cancellation) -->
<script>
    // Auto-scroll to alert if present
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.querySelector('.alert-success, .alert-danger');
        if (alert) {
            alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>