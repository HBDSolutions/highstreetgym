<?php
// DEBUG: Check if variables exist
echo '<pre>DEBUG in VIEW:';
echo "\ndayScheduleHTML exists: " . (isset($dayScheduleHTML) ? 'YES' : 'NO');
if (isset($dayScheduleHTML)) {
    echo "\nMonday HTML length: " . strlen($dayScheduleHTML['Monday']);
    echo "\nTuesday HTML length: " . strlen($dayScheduleHTML['Tuesday']);
}
echo '</pre>';
?>

<div class="container my-4">
    <h1 class="mb-4">Class Schedule</h1>
    
    <?php if ($showLoginPrompt): ?>
        <div class="alert alert-info">
            <a href="login.php" class="alert-link">Login</a> or 
            <a href="register.php" class="alert-link">Register</a> to book classes
        </div>
    <?php endif; ?>
    
    <?php if ($showBookingAlert): ?>
        <div class="alert alert-<?= $bookingSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
            <?= htmlspecialchars($bookingMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?= $dayScheduleHTML['Monday'] ?>
    <?= $dayScheduleHTML['Tuesday'] ?>
    <?= $dayScheduleHTML['Wednesday'] ?>
    <?= $dayScheduleHTML['Thursday'] ?>
    <?= $dayScheduleHTML['Friday'] ?>
    <?= $dayScheduleHTML['Saturday'] ?>
    <?= $dayScheduleHTML['Sunday'] ?>
    
    <?php if ($showNoScheduleMessage): ?>
        <div class="alert alert-warning">
            No classes scheduled at this time. Please check back later!
        </div>
    <?php endif; ?>
</div>