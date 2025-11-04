<?php /* CLASSES VIEW */ ?>
<section class="container mt-5">
  <h1 class="text-center mb-4">Class Schedule</h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (empty($schedule)): ?>
    <p class="text-center text-muted">No classes available at this time.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Day</th>
            <th>Class</th>
            <th>Trainer</th>
            <th>Start</th>
            <th>End</th>
            <th>Capacity</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($schedule as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['day_full']) ?></td>
              <td><?= htmlspecialchars($row['class_name']) ?></td>
              <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
              <td><?= htmlspecialchars($row['start_time']) ?></td>
              <td><?= htmlspecialchars($row['end_time']) ?></td>
              <td><?= htmlspecialchars($row['max_capacity']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</section>