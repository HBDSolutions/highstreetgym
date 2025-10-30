<!-- Classes Content View -->
<main class="container my-4">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    
    <?php if ($showLoginPrompt): ?>
        <?php include __DIR__ . '/../partials/classes/classes_login.php'; ?>
    <?php endif; ?>
    
    <?php if ($showBookingMessage): ?>
        <?php include __DIR__ . '/../partials/classes/booking_message.php'; ?>
    <?php endif; ?>
    
    <?php if ($showNoSchedule): ?>
        <?php include __DIR__ . '/../partials/classes/no_schedule.php'; ?>
    <?php endif; ?>
    
    <?php if ($showSchedule): ?>
        <?php foreach ($scheduleByDay as $dayName => $dayClasses): ?>
            <?php if (!empty($dayClasses)): ?>
                <?php include __DIR__ . '/../partials/classes/schedule_day.php'; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</main>