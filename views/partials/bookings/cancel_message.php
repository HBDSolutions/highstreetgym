<!-- Bookings Cancel Message Partial -->
<div class="alert alert-<?= $cancelSuccess ? 'success' : 'danger' ?> alert-dismissible fade show">
    <?= htmlspecialchars($cancelMessage) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>