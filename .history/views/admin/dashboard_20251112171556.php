<?php
// ADMIN HOME VIEW
// PURPOSE: PROVIDES ADMIN LANDING PAGE WITH IMPORT LINKS
?>

<!-- SKIP LINK FOR ACCESSIBILITY -->
<a class="skip-link" href="#main">Skip to content</a>

<!-- ADMIN HOME CONTENT -->
<section class="container my-5">
    
    <header class="text-center mb-5">
        <h1 class="display-4">Welcome back, <?= htmlspecialchars($currentUser['user_name']) ?></h1>
        <p class="lead">Admin Dashboard - Manage your gym efficiently</p>
    </header>
    
    <section class="row g-4 mb-5">
        <article class="col-md-4">
            <div class="card h-100 text-center">
                <img src="/highstreetgym/assets/img/members-admin.jpg" class="card-img-top" alt="Manage Members">
                <div class="card-body">
                    <h2 class="h5">Import Members</h2>
                    <p>Bulk import member data via XML upload.</p>
                    <a href="/highstreetgym/controllers/content/xml_import_controller.php?type=members" 
                       class="btn btn-primary">Import Members</a>
                </div>
            </div>
        </article>
        
        <article class="col-md-4">
            <div class="card h-100 text-center">
                <img src="/highstreetgym/assets/img/classes-admin.jpg" class="card-img-top" alt="Manage Classes">
                <div class="card-body">
                    <h2 class="h5">Import Classes</h2>
                    <p>Add new fitness classes to your schedule.</p>
                    <a href="/highstreetgym/controllers/content/xml_import_controller.php?type=classes" 
                       class="btn btn-primary">Import Classes</a>
                </div>
            </div>
        </article>
        
        <article class="col-md-4">
            <div class="card h-100 text-center">
                <img src="/highstreetgym/assets/img/schedule-admin.jpg" class="card-img-top" alt="Manage Schedules">
                <div class="card-body">
                    <h2 class="h5">Import Schedules</h2>
                    <p>Update class timetables and availability.</p>
                    <a href="/highstreetgym/controllers/content/xml_import_controller.php?type=schedules" 
                       class="btn btn-primary">Import Schedules</a>
                </div>
            </div>
        </article>
    </section>
    
</section>