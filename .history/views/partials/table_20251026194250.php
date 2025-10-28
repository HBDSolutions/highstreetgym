<?php // expects $headers and $rows ?>
<table class="table table-striped table-bordered">
  <thead><tr>
    <?php foreach (($headers ?? []) as $h): ?>
      <th><?= htmlspecialchars($h) ?></th>
    <?php endforeach; ?>
  </tr></thead>
  <tbody>
    <?php foreach (($rows ?? []) as $r): ?>
      <tr>
        <?php foreach (($headers ?? []) as $h): ?>
          <td><?= htmlspecialchars($r[$h] ?? '') ?></td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>