<!-- Bookings List Partial -->
<div class="row g-3">
    <?php foreach ($activeBookings as $booking): ?>
        <div class="col-md-6 col-lg-4">
            <article class="card h-100 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="card-title mb-0">
                            <?= htmlspecialchars($booking['class_name']) ?>
                        </h3>
                        <span class="badge bg-success">Confirmed</span>
                    </div>
                    
                    <p><strong>When:</strong> <?= htmlspecialchars($booking['day_of_week']) ?></p>
                    <p class="text-muted">
                        <strong>Time:</strong> <?= $booking['start_time'] ?> - <?= $booking['end_time'] ?>
                    </p>
                    <p><strong>Trainer:</strong> <?= htmlspecialchars($booking['trainer_name']) ?></p>
                    <p class="small text-muted">Booked on: <?= $booking['booking_date'] ?></p>
                    
                    <?php if ($booking['description']): ?>
                        <p class="small"><?= htmlspecialchars($booking['description']) ?></p>
                    <?php endif; ?>
                    
                    <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')" class="mt-3">
                        <input type="hidden" name="action" value="cancel">
                        <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                        <button type="submit" class="btn btn-danger w-100">Cancel Booking</button>
                    </form>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
</div>