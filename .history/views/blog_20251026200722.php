<?php
$title = "Member Blog";
$items = ['Welcome to our Member blog!', 'Share your journey with other members!'];
$view  = __FILE__;
include __DIR__ . '/layouts/base.php';
?>
<h1 class="mb-3"><?= htmlspecialchars($title) ?></h1>
<?php include __DIR__ . '/partials/list.php'; ?>