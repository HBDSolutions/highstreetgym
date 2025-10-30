<!-- Classes Content View -->
<div class="container my-4">
    <h1 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
    
    <!-- Login Prompt for Non-authenticated Users -->
    <?php if ($showLoginPrompt): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="alert-link">Login</a> or 
            <a href="/highstreetgym/controllers/content/auth/register_controller.php" class="alert-link">Register</a> to book classes
        </div>
    <?php endif; ?>
    
    <!-- Booking Alert Messages -->
    <?php if ($showBookingAlert): ?>
        <div class="alert alert-<?= $bookingSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
            <i class="bi bi-<?= $bookingSuccess ? 'check-circle' : 'exclamation-triangle' ?>"></i>
            <?= htmlspecialchars($bookingMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Weekly Schedule -->
    <?php if (!$showNoScheduleMessage): ?>
        <?= $dayScheduleHTML['Monday'] ?>
        <?= $dayScheduleHTML['Tuesday'] ?>
        <?= $dayScheduleHTML['Wednesday'] ?>
        <?= $dayScheduleHTML['Thursday'] ?>
        <?= $dayScheduleHTML['Friday'] ?>
        <?= $dayScheduleHTML['Saturday'] ?>
        <?= $dayScheduleHTML['Sunday'] ?>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            No classes scheduled at this time. Please check back later!
        </div>
    <?php endif; ?>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.card-title {
    font-weight: 600;
}
</style>