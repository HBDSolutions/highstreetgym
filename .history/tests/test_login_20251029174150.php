<?php
// TEST LOGIN FUNCTIONALITY
// Place in: /highstreetgym/tests/test_login.php
// Access via: http://localhost/highstreetgym/tests/test_login.php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Test - High Street Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container my-5">
        <h1><i class="bi bi-bug"></i> Login Functionality Test</h1>
        <p class="text-muted">Test all login scenarios and session management</p>
        
        <div class="card my-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="bi bi-gear"></i> Session Management Tests</h3>
            </div>
            <div class="card-body">
                <?php
                // Test 1: Set success message
                if (isset($_GET['set_success'])) {
                    $_SESSION['success_message'] = 'Registration successful! Please login.';
                    echo '<div class="alert alert-success"><i class="bi bi-check-circle"></i> ✅ Set success message in session</div>';
                }
                
                // Test 2: Set modal error
                if (isset($_GET['set_modal_error'])) {
                    $_SESSION['modal_login_error'] = 'Invalid email or password (from modal)';
                    echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> ✅ Set modal error in session</div>';
                }
                
                // Test 3: Clear all
                if (isset($_GET['clear'])) {
                    unset($_SESSION['success_message']);
                    unset($_SESSION['modal_login_error']);
                    session_destroy();
                    session_start();
                    echo '<div class="alert alert-info"><i class="bi bi-trash"></i> ✅ Cleared all test messages and destroyed session</div>';
                }
                ?>
                
                <div class="d-grid gap-2">
                    <a href="?set_success=1" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Set Success Message
                    </a>
                    <a href="?set_modal_error=1" class="btn btn-danger">
                        <i class="bi bi-exclamation-triangle"></i> Set Modal Error
                    </a>
                    <a href="?clear=1" class="btn btn-secondary">
                        <i class="bi bi-trash"></i> Clear All Messages
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card my-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> Login Page Tests</h3>
            </div>
            <div class="card-body">
                <p>Click these links to test different login page scenarios:</p>
                <div class="list-group">
                    <a href="../controllers/login.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-file-earmark"></i> Normal Login Page
                        <span class="badge bg-secondary float-end">Default</span>
                    </a>
                    <a href="../controllers/login.php?msg=session_expired" class="list-group-item list-group-item-action">
                        <i class="bi bi-clock-history"></i> Session Expired Message
                        <span class="badge bg-warning float-end">Info Alert</span>
                    </a>
                    <a href="../controllers/login.php?msg=login_required" class="list-group-item list-group-item-action">
                        <i class="bi bi-lock"></i> Login Required Message
                        <span class="badge bg-warning float-end">Info Alert</span>
                    </a>
                    <a href="../controllers/login.php?redirect=controllers/mybookings.php" class="list-group-item list-group-item-action">
                        <i class="bi bi-arrow-return-right"></i> With Redirect Parameter
                        <span class="badge bg-info float-end">Redirect Test</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card my-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0"><i class="bi bi-list-check"></i> Step-by-Step Test Scenarios</h3>
            </div>
            <div class="card-body">
                <h5>Scenario 1: Test Success Message</h5>
                <ol>
                    <li>Click <a href="?set_success=1" class="btn btn-sm btn-success">Set Success</a></li>
                    <li>Then click <a href="../controllers/login.php" class="btn btn-sm btn-primary">View Login Page</a></li>
                    <li><strong>Expected:</strong> Green success alert should appear</li>
                </ol>
                
                <hr>
                
                <h5>Scenario 2: Test Modal Error (Auto-show)</h5>
                <ol>
                    <li>Click <a href="?set_modal_error=1" class="btn btn-sm btn-danger">Set Modal Error</a></li>
                    <li>Then click <a href="../index.php" class="btn btn-sm btn-primary">View Homepage</a></li>
                    <li><strong>Expected:</strong> Login modal should auto-open with error message</li>
                </ol>
                
                <hr>
                
                <h5>Scenario 3: Test Login Form Submission</h5>
                <ol>
                    <li>Go to <a href="../controllers/login.php" class="btn btn-sm btn-primary">Login Page</a></li>
                    <li>Enter invalid credentials and submit</li>
                    <li><strong>Expected:</strong> Red error alert should appear</li>
                    <li>Enter valid credentials and submit</li>
                    <li><strong>Expected:</strong> Redirect to homepage, logged in</li>
                </ol>
            </div>
        </div>
        
        <div class="card my-4">
            <div class="card-header bg-warning">
                <h3 class="mb-0"><i class="bi bi-database"></i> Current Session State</h3>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded"><?php 
                    if (empty($_SESSION)) {
                        echo "Session is empty\n";
                    } else {
                        print_r($_SESSION); 
                    }
                ?></pre>
            </div>
        </div>
        
        <div class="card my-4 border-danger">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Debug Login Form Context</h3>
            </div>
            <div class="card-body">
                <p>If alerts are not showing, check what context the form is receiving:</p>
                <ol>
                    <li>Set a success message: <a href="?set_success=1" class="btn btn-sm btn-success">Set Success</a></li>
                    <li>Open <code>views/partials/forms/login_form.php</code></li>
                    <li>Add this at line 17 (after context extraction):
                        <pre class="bg-light p-2 mt-2 rounded"><code>&lt;?php
// DEBUG - Remove after testing
echo "&lt;div class='alert alert-secondary'&gt;";
echo "&lt;h5&gt;DEBUG: Login Form Context&lt;/h5&gt;";
echo "&lt;pre&gt;" . print_r($loginFormContext, true) . "&lt;/pre&gt;";
echo "&lt;/div&gt;";
?&gt;</code></pre>
                    </li>
                    <li>Visit login page - you should see the context array displayed</li>
                </ol>
            </div>
        </div>
        
        <hr>
        <div class="d-flex gap-2">
            <a href="../index.php" class="btn btn-outline-secondary">
                <i class="bi bi-house"></i> Back to Home
            </a>
            <a href="../controllers/login.php" class="btn btn-outline-primary">
                <i class="bi bi-box-arrow-in-right"></i> Go to Login
            </a>
            <a href="?clear=1" class="btn btn-outline-danger">
                <i class="bi bi-trash"></i> Reset All Tests
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>