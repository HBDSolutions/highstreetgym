<?php // expects $items ?>
<ul class="list-group">
  <?php foreach (($items ?? []) as $i): ?>
    <li class="list-group-item"><?= htmlspecialchars(is_array($i) ? ($i['text'] ?? '') : $i) ?></li>
  <?php endforeach; ?>
</ul>