<!-- Bookings Content View -->
<section class="container my-4">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    
    <?php if ($showCancelMessage): ?>
        <?php include __DIR__ . '/../partials/bookings/cancel_message.php'; ?>
    <?php endif; ?>
    
    <section class="mb-5">
        <h2>Active Bookings</h2>
        
        <?php if ($showNoBookings): ?>
            <?php include __DIR__ . '/../partials/bookings/no_bookings.php'; ?>
        <?php endif; ?>
        
        <?php if ($hasActiveBookings): ?>
            <?php include __DIR__ . '/../partials/bookings/bookings_list.php'; ?>
        <?php endif; ?>
    </section>
</section>