<?php
// ADMIN DASHBOARD VIEW
?>
<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Admin — Imports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ASSUMES YOUR MAIN CSS/BOOTSTRAP IS INCLUDED IN LAYOUT OR BASE -->
    <link rel="stylesheet" href="/highstreetgym/assets/css/bootstrap.min.css">
    </head>
    <body>
    <main class="container my-5">
        <h1 class="mb-4">Admin</h1>

        <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h2 class="h5">Import Members (XML)</h2>
                <p class="text-muted mb-4">Upload memberAdd.xml and validate against DTD</p>
                <form method="get" action="/highstreetgym/controllers/content/xml_import_controller.php" class="mt-auto">
                <input type="hidden" name="prefill" value="members">
                <button type="submit" class="btn btn-primary btn-sm">Open Import</button>
                </form>
            </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h2 class="h5">Import Classes (XML)</h2>
                <p class="text-muted mb-4">Upload classAdd.xml and validate against DTD</p>
                <form method="get" action="/highstreetgym/controllers/content/xml_import_controller.php" class="mt-auto">
                <input type="hidden" name="prefill" value="classes">
                <button type="submit" class="btn btn-primary btn-sm">Open Import</button>
                </form>
            </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h2 class="h5">Import Schedules (XML)</h2>
                <p class="text-muted mb-4">Upload scheduleAdd.xml and validate against DTD</p>
                <form method="get" action="/highstreetgym/controllers/content/xml_import_controller.php" class="mt-auto">
                <input type="hidden" name="prefill" value="schedules">
                <button type="submit" class="btn btn-primary btn-sm">Open Import</button>
                </form>
            </div>
            </div>
        </div>
        </div>

        <hr class="my-4">

        <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <div class="card h-100">
            <div class="card-body">
                <h2 class="h6">Recent Admin Actions</h2>
                <p class="text-muted mb-0">Optional: list last 10 imports from <code>xml_imports</code></p>
            </div>
            </div>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <div class="card h-100">
            <div class="card-body">
                <h2 class="h6">Shortcuts</h2>
                <ul class="mb-0">
                <li><a href="/highstreetgym/controllers/content/classes_controller.php">View Class Schedule</a></li>
                <li><a href="/highstreetgym/controllers/content/blog_controller.php">Manage Blog</a></li>
                </ul>
            </div>
            </div>
        </div>
        </div>

    </main>
    </body>
</html>