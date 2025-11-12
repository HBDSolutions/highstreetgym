<?php
// ADMIN HOME VIEW
// PURPOSE: PROVIDES ADMIN LANDING PAGE WITH IMPORT LINKS
?>

<!-- SKIP LINK FOR ACCESSIBILITY -->
<a class="skip-link" href="#main">Skip to content</a>

<!-- ADMIN HOME CONTENT -->
<section class="container my-5">
    
    <header class="text-center mb-5">
        <h1 class="display-4">Administrator: <?= htmlspecialchars($currentUser['user_name']) ?></h1>
    </header>
    
    <!-- IMPORT TILES -->
    <section aria-label="Admin Imports" class="d-flex justify-content-center">
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
    
</section>