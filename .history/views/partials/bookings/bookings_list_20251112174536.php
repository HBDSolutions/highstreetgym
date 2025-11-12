<!-- Bookings List Partial -->
<div class="row g-3">
    <?php foreach ($activeBookings as $booking): ?>
        <div class="col-md-6 col-lg-4">
            <article class="card h-100 border-success">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title">
                        <?= htmlspecialchars($booking['class_name']) ?>
                    </h3>
                    
                    <p><strong>When:</strong> <?= htmlspecialchars($booking['day_of_week']) ?></p>
                    <p class="text-muted">
                        <strong>Time:</strong> <?= $booking['start_time'] ?> - <?= $booking['end_time'] ?>
                    </p>
                    <p><strong>Trainer:</strong> <?= htmlspecialchars($booking['trainer_name']) ?></p>
                    <p class="small text-muted">Booked on: <?= $booking['booking_date'] ?></p>
                    
                    <?php if ($booking['description']): ?>
                        <p class="small"><?= htmlspecialchars($booking['description']) ?></p>
                    <?php endif; ?>
                    
                    <!-- Bottom row: Confirmed status (left) + Cancel button (right) -->
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="text-success fw-bold">Confirmed</span>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')" class="m-0">
                            <input type="hidden" name="action" value="cancel">
                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                            <button type="submit" class="btn btn-danger">Cancel Booking</button>
                        </form>
                    </div>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
</div>