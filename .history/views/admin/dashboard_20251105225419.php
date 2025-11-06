<?php
// ADMIN HOME VIEW
// PURPOSE: PROVIDES ADMIN LANDING PAGE WITH IMPORT LINKS

$title = 'Admin Home';
ob_start();
?>

<!-- MAIN CONTENT -->
<a class="skip-link" href="#main">Skip to content</a>

<main id="main">

  <!-- PAGE TITLE -->
  <header>
    <h1><?= htmlspecialchars($title) ?></h1>
  </header>

  <!-- IMPORT LINKS -->
  <section aria-label="Admin Imports">
    <div class="tile">
      <a href="/admin/import?type=members">Import Members</a>
    </div>

    <div class="tile">
      <a href="/admin/import?type=classes">Import Classes</a>
    </div>

    <div class="tile">
      <a href="/admin/import?type=schedules">Import Schedules</a>
    </div>
  </section>

</main>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin_layout.php';
