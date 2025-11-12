<?php
// XML IMPORT VIEW FILE
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/navigation.php';

// NORMALISE PREFILL
$prefill = isset($prefill) ? (string)$prefill : '';

// NAV VARS FOR PARTIAL
$navVars = get_navigation_data();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>XML Import - High Street Gym</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  
  <?php include __DIR__ . '/../partials/header.php'; ?>

  <!-- SKIP LINK FOR ACCESSIBILITY -->
  <a class="skip-link" href="#main">Skip to content</a>

  <!-- MAIN CONTENT -->
  <main id="main" class="container my-5 flex-grow-1">
      
      <header class="text-center mb-5">
          <h1 class="display-4">XML Import</h1>
          <p class="lead">Upload XML to add or update Members, Classes, or Schedules.</p>
          <p class="text-muted">Files must pass DTD validation.</p>
      </header>

      <!-- IMPORT FORM -->
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="card shadow-sm">
                  <div class="card-body p-4">
                      <form method="post"
                          action="/highstreetgym/controllers/content/xml_import_controller.php"
                          enctype="multipart/form-data">
                          
                          <input type="hidden" name="csrf_token"
                              value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES) ?>">

                          <!-- IMPORT TYPE -->
                          <fieldset class="mb-4">
                              <legend class="h5 mb-3">Import Type</legend>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="import_type" 
                                         value="members" id="type-members"
                                         <?= $prefill === 'members' ? 'checked' : '' ?>>
                                  <label class="form-check-label" for="type-members">
                                      Members
                                  </label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="import_type" 
                                         value="classes" id="type-classes"
                                         <?= $prefill === 'classes' ? 'checked' : '' ?>>
                                  <label class="form-check-label" for="type-classes">
                                      Classes
                                  </label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="import_type" 
                                         value="schedules" id="type-schedules"
                                         <?= $prefill === 'schedules' ? 'checked' : '' ?>>
                                  <label class="form-check-label" for="type-schedules">
                                      Schedules
                                  </label>
                              </div>
                          </fieldset>

                          <!-- MODE -->
                          <fieldset class="mb-4">
                              <legend class="h5 mb-3">Mode</legend>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="mode" 
                                         value="insert" id="mode-insert" checked>
                                  <label class="form-check-label" for="mode-insert">
                                      Insert only
                                  </label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="mode" 
                                         value="upsert" id="mode-upsert">
                                  <label class="form-check-label" for="mode-upsert">
                                      Upsert (update if exists)
                                  </label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="mode" 
                                         value="dry_run" id="mode-dry">
                                  <label class="form-check-label" for="mode-dry">
                                      Dry run (validate &amp; preview only)
                                  </label>
                              </div>
                          </fieldset>

                          <!-- FILE UPLOAD -->
                          <div class="mb-4">
                              <label for="xml-file" class="form-label h5">XML File</label>
                              <input type="file" class="form-control" name="xml_file" 
                                     id="xml-file" accept=".xml" required>
                          </div>

                          <!-- SUBMIT BUTTON -->
                          <div class="d-grid">
                              <button type="submit" class="btn btn-primary btn-lg">Run Import</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

  </main>

  <?php include __DIR__ . '/../partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>