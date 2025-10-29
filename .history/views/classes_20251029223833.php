<div class="container my-4">
    <h1 class="mb-4"><i class="bi bi-calendar-week"></i> Class Schedule</h1>
    
    <?php if (!$isLoggedIn): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> 
            <a href="login.php" class="alert-link">Login</a> or 
            <a href="register.php" class="alert-link">Register</a> to book classes
        </div>
    <?php endif; ?>
    
    <?php if ($showBookingAlert): ?>
        <div class="alert alert-<?= $bookingSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
            <i class="bi bi-<?= $bookingSuccess ? 'check-circle' : 'exclamation-triangle' ?>"></i>
            <?= htmlspecialchars($bookingMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php foreach ($daysOfWeek as $day): ?>
        <?php if (isset($scheduleByDay[$day]) && count($scheduleByDay[$day]) > 0): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-calendar-day"></i> <?= $day ?></h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php foreach ($scheduleByDay[$day] as $class): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 <?= $class['is_booked'] ? 'border-success border-2' : '' ?>">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($class['class_name']) ?>
                                            <?php if ($class['is_booked']): ?>
                                                <span class="badge bg-success">Booked</span>
                                            <?php endif; ?>
                                        </h5>
                                        
                                        <p class="card-text text-muted mb-2">
                                            <i class="bi bi-clock"></i>
                                            <?= $class['start_time'] ?> - <?= $class['end_time'] ?>
                                            <span class="badge bg-secondary ms-1"><?= $class['duration'] ?> min</span>
                                        </p>
                                        
                                        <p class="card-text mb-2">
                                            <i class="bi bi-person-badge"></i>
                                            <strong>Trainer:</strong> <?= htmlspecialchars($class['trainer_name']) ?>
                                        </p>
                                        
                                        <p class="card-text mb-2">
                                            <i class="bi bi-signal"></i>
                                            <strong>Level:</strong> 
                                            <span class="badge bg-info"><?= $class['difficulty_level'] ?></span>
                                        </p>
                                        
                                        <p class="card-text mb-3">
                                            <i class="bi bi-people"></i>
                                            <strong>Spots:</strong> 
                                            <?php if ($class['is_full']): ?>
                                                <span class="text-danger fw-bold">FULL</span>
                                            <?php else: ?>
                                                <span class="text-success fw-bold">
                                                    <?= $class['spots_available'] ?> / <?= $class['max_capacity'] ?> available
                                                </span>
                                            <?php endif; ?>
                                        </p>
                                        
                                        <?php if ($class['description']): ?>
                                            <p class="card-text small text-muted mb-3">
                                                <?= htmlspecialchars($class['description']) ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if ($class['show_book_button']): ?>
                                            <form method="POST">
                                                <input type="hidden" name="action" value="book">
                                                <input type="hidden" name="schedule_id" value="<?= $class['schedule_id'] ?>">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-calendar-plus"></i> Book Now
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <?php if ($class['show_cancel_button']): ?>
                                            <form method="POST" onsubmit="return confirm('Cancel this booking?');">
                                                <input type="hidden" name="action" value="cancel">
                                                <input type="hidden" name="booking_id" value="<?= $class['booking_id'] ?>">
                                                <button type="submit" class="btn btn-outline-danger w-100">
                                                    <i class="bi bi-x-circle"></i> Cancel Booking
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <?php if ($class['show_full_button']): ?>
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="bi bi-x-circle"></i> Class Full
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($class['show_login_button']): ?>
                                            <a href="login.php" class="btn btn-outline-primary w-100">
                                                <i class="bi bi-box-arrow-in-right"></i> Login to Book
                                            </a>
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
</div>