<?php /* CLASSES VIEW - CARD LAYOUT */ ?>
<section class="container my-5">
  <h1 class="text-center mb-4">Class Schedule</h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (empty($schedule)): ?>
    <p class="text-center text-muted">No classes available right now.</p>
  <?php else: ?>
    <?php
      // group by day for headings + sections
      $byDay = [];
      foreach ($schedule as $row) { $byDay[$row['day_full']][] = $row; }
      $weekdayOrder = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
      usort($weekdayOrder, function($a,$b) use($byDay){
        $ia = array_key_exists($a,$byDay) ? array_keys($byDay) : [];
        $ib = array_key_exists($b,$byDay) ? array_keys($byDay) : [];
        // keep Mon..Sun order; fallback natural if a day has no classes
        return array_search($a,['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])
             <=> array_search($b,['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']);
      });
    ?>

    <?php foreach ($weekdayOrder as $day): ?>
      <?php if (empty($byDay[$day])) continue; ?>
      <h2 class="h4 mt-4 mb-3"><?= htmlspecialchars($day) ?></h2>

      <div class="row">
        <?php foreach ($byDay[$day] as $card): ?>
          <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex flex-column">
                <h3 class="h5 card-title mb-1"><?= htmlspecialchars($card['class_name']) ?></h3>
                <p class="mb-2 text-muted"><?= htmlspecialchars($card['first_name'] . ' ' . $card['last_name']) ?></p>

                <div class="d-flex align-items-center mb-2">
                  <div class="mr-3"><strong>Start:</strong> <?= htmlspecialchars($card['start_time']) ?></div>
                  <div><strong>End:</strong> <?= htmlspecialchars($card['end_time']) ?></div>
                </div>
                <div class="mb-3"><strong>Capacity:</strong> <?= htmlspecialchars($card['max_capacity']) ?></div>

                <div class="mt-auto">
                  <!-- Replace with real form/action when you wire BookingService -->
                  <a href="#" class="btn btn-primary btn-sm" role="button" aria-disabled="true">Book</a>
                  <!-- If already booked, show Cancel instead -->
                  <!-- <a href="#" class="btn btn-outline-secondary btn-sm">Cancel</a> -->
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</section>
