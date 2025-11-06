<?php
// ADMIN HOME VIEW
// PURPOSE: PROVIDES ADMIN LANDING PAGE WITH IMPORT LINKS
?>

<!-- MAIN CONTENT -->
<a class="skip-link" href="#main">Skip to content</a>

<main id="main">
  <!-- PAGE TITLE -->
  <header>
    <h1>Admin Home</h1>
  </header>

  <!-- IMPORT LINKS -->
  <section aria-label="Admin Imports">
    <div class="tile">
      <a href="/highstreetgym/controllers/content/xml_import_controller.php?type=members">Import Members</a>
    </div>

    <div class="tile">
      <a href="/highstreetgym/controllers/content/xml_import_controller.php?type=classes">Import Classes</a>
    </div>

    <div class="tile">
      <a href="/highstreetgym/controllers/content/xml_import_controller.php?type=schedules">Import Schedules</a>
    </div>
  </section>
</main>