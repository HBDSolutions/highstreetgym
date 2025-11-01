<!-- Classes Schedule Day Partial -->
<section class="mb-4">
    <h3 class="border-bottom pb-2"><?= htmlspecialchars($dayName) ?></h3>
    <div class="row g-3">
        <?php foreach ($dayClasses as $class): ?>
            <div class="col-md-6 col-lg-4">
                <article class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title"><?= htmlspecialchars($class['class_name']) ?></h4>
                        <p class="text-muted">
                            <?= date('g:i A', strtotime($class['start_time'])) ?> - 
                            <?= date('g:i A', strtotime($class['end_time'])) ?>
                        </p>
                        <p><?= htmlspecialchars($class['description']) ?></p>
                        <p><strong>Trainer:</strong> <?= htmlspecialchars($class['trainer_first_name'] . ' ' . $class['trainer_last_name']) ?></p>
                        
                        <?php if ($canBookClasses): ?>
                            <form method="POST" class="mt-3">
                                <input type="hidden" name="action" value="book">
                                <input type="hidden" name="schedule_id" value="<?= $class['schedule_id'] ?>">
                                <button type="submit" class="btn btn-primary w-100">Book Class</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>