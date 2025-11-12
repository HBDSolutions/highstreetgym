<?php
// XML IMPORT RESULT VIEW FILE
require_once __DIR__ . '/../../models/session.php';
require_once __DIR__ . '/../../models/navigation.php';

// NAV VARS FOR PARTIAL
$navVars = get_navigation_data();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Import Result - High Street Gym</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/highstreetgym/assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  
  <?php include __DIR__ . '/../partials/header.php'; ?>

  <!-- MAIN CONTENT -->
  <main class="container my-5 flex-grow-1">
    
    <header class="text-center mb-5">
      <h1 class="display-4">Import Result</h1>
    </header>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        
        <?php if (!empty($error)): ?>
          <!-- ERROR MESSAGE -->
          <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Import Failed</h4>
            <p class="mb-0"><?= htmlspecialchars($error) ?></p>
          </div>
          
          <div class="text-center mt-4">
            <a href="/highstreetgym/controllers/content/xml_import_controller.php" class="btn btn-primary">
              Try Again
            </a>
          </div>
          
        <?php elseif (!empty($report)): ?>
          <!-- SUCCESS MESSAGE -->
          <div class="alert alert-success mb-4" role="alert">
            <h4 class="alert-heading">Import Completed</h4>
          </div>

          <!-- REPORT DETAILS -->
          <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color: var(--hsg-secondary);">
              <h5 class="mb-0">Import Details</h5>
            </div>
            
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <?php if (isset($report['mode'])): ?>
                    <tr>
                      <th scope="row" style="width: 40%;">Mode</th>
                      <td><?= htmlspecialchars($report['mode']) ?></td>
                    </tr>
                  <?php endif; ?>
                  
                  <?php if (isset($report['type'])): ?>
                    <tr>
                      <th scope="row">Import Type</th>
                      <td><?= htmlspecialchars(ucfirst($report['type'])) ?></td>
                    </tr>
                  <?php endif; ?>
                  
                  <?php if (isset($report['inserted'])): ?>
                    <tr>
                      <th scope="row">Records Inserted</th>
                      <td><?= (int)$report['inserted'] ?></td>
                    </tr>
                  <?php endif; ?>
                  
                  <?php if (isset($report['updated'])): ?>
                    <tr>
                      <th scope="row">Records Updated</th>
                      <td><?= (int)$report['updated'] ?></td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              
              <?php if (isset($report['errors']) && !empty($report['errors'])): ?>
                <div class="mt-3">
                  <p class="fw-bold text-danger">Errors:</p>
                  <ul class="list-group">
                    <?php foreach ($report['errors'] as $error): ?>
                      <li class="list-group-item list-group-item-danger">
                        <?= htmlspecialchars($error) ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
              
              <?php if (isset($report['warnings']) && !empty($report['warnings'])): ?>
                <div class="mt-3">
                  <p class="fw-bold text-warning">Warnings:</p>
                  <ul class="list-group">
                    <?php foreach ($report['warnings'] as $warning): ?>
                      <li class="list-group-item list-group-item-warning">
                        <?= htmlspecialchars($warning) ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <!-- RAW DATA (COLLAPSED) -->
              <div class="mt-4">
                <details>
                  <summary class="btn btn-sm btn-outline-secondary">View Raw Report Data</summary>
                  <pre class="mt-3 p-3 bg-light border rounded"><code><?= htmlspecialchars(json_encode($report, JSON_PRETTY_PRINT), ENT_QUOTES) ?></code></pre>
                </details>
              </div>
            </div>
          </div>

          <div class="text-center mt-4">
            <a href="/highstreetgym/controllers/content/xml_import_controller.php" class="btn btn-primary">
              Import More Data
            </a>
            <a href="/highstreetgym/controllers/content/admin_controller.php" class="btn btn-secondary">
              Back to Dashboard
            </a>
          </div>
          
        <?php else: ?>
          <!-- NO REPORT -->
          <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">No Report Available</h4>
            <p class="mb-0">The import did not generate a report.</p>
          </div>
          
          <div class="text-center mt-4">
            <a href="/highstreetgym/controllers/content/xml_import_controller.php" class="btn btn-primary">
              Back to Import
            </a>
          </div>
        <?php endif; ?>

      </div>
    </div>

  </main>

  <?php include __DIR__ . '/../partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>