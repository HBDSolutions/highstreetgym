<!-- Bookings Content View -->
<div class="container my-4">
    <h1 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
    
    <!-- Cancellation Alert -->
    <?php if ($showCancelAlert): ?>
        <div class="alert alert-<?= $cancelSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
            <i class="bi bi-<?= $cancelSuccess ? 'check-circle' : 'exclamation-triangle' ?>"></i>
            <?= htmlspecialchars($cancelMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Active Bookings Section -->
    <section class="mb-5">
        <h2 class="mb-3">Active Bookings</h2>
        
        <?php if ($hasActiveBookings): ?>
            <div class="row g-3">
                <?= $activeBookingsHTML ?>
            </div>
        <?php endif; ?>
        
        <?php if ($showNoBookingsMessage): ?>
            <div class="alert alert-light text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                <p class="mt-3 mb-2">You don't have any active bookings yet.</p>
                <a href="/highstreetgym/controllers/content/classes_controller.php" class="btn btn-success mt-2">
                    <i class="bi bi-calendar-plus"></i> Browse Classes
                </a>
            </div>
        <?php endif; ?>
    </section>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>