<div class="container my-4">
    <h1 class="mb-4">My Bookings</h1>
    
    <?php if ($showCancelAlert): ?>
        <div class="alert alert-<?= $cancelSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
            <?= htmlspecialchars($cancelMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($hasActiveBookings): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Active Bookings</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?= $activeBookingsHTML ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($showNoBookingsMessage): ?>
        <div class="alert alert-info">
            <h4>No Active Bookings</h4>
            <p>You don't have any active class bookings.</p>
            <a href="/highstreetgym/controllers/classescontroller.php" class="btn btn-primary">Browse Classes</a>
        </div>
    <?php endif; ?>
</div>