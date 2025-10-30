<!-- Classes Booking Message Partial -->
<div class="alert alert-<?= $bookingSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
    <?= htmlspecialchars($bookingMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>