<?php // ADMIN DASHBOARD VIEW ?>
<div class="container my-4">
  <div class="mb-4">
    <h1 class="h3 fw-semibold">Admin</h1>
    <p class="text-muted mb-0">XML imports and quick links.</p>
  </div>

  <div class="row g-3">
    <div class="col-12 col-md-4">
      <div class="card h-100 shadow-sm rounded-3">
        <div class="card-body">
          <h2 class="h5 mb-2">Import Members (XML)</h2>
          <p class="text-muted mb-3">Upload memberAdd.xml and validate against DTD.</p>
          <a href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=members" class="btn btn-primary">Open Import</a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card h-100 shadow-sm rounded-3">
        <div class="card-body">
          <h2 class="h5 mb-2">Import Classes (XML)</h2>
          <p class="text-muted mb-3">Upload classAdd.xml and validate against DTD.</p>
          <a href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=classes" class="btn btn-primary">Open Import</a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card h-100 shadow-sm rounded-3">
        <div class="card-body">
          <h2 class="h5 mb-2">Import Schedules (XML)</h2>
          <p class="text-muted mb-3">Upload scheduleAdd.xml and validate against DTD.</p>
          <a href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=schedules" class="btn btn-primary">Open Import</a>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mt-4">
    <div class="col-12 col-lg-8">
      <div class="card h-100 shadow-sm rounded-3">
        <div class="card-body">
          <h2 class="h5 mb-3">Recent Admin Actions</h2>
          <p class="text-muted mb-0">List last 10 imports from <code>xml_imports</code> if required.</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card h-100 shadow-sm rounded-3">
        <div class="card-body">
          <h2 class="h5 mb-3">Shortcuts</h2>
          <div class="d-grid gap-2">
            <a class="btn btn-outline-secondary" href="/highstreetgym/controllers/content/classes_controller.php">View Class Schedule</a>
            <a class="btn btn-outline-secondary" href="/highstreetgym/controllers/content/blog_controller.php">Manage Blog</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>