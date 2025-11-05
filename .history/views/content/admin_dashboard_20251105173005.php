<?php
/**
 * ADMIN DASHBOARD VIEW
 * 
 * RESPONSIBILITY: Display admin dashboard content
 */
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h2 mb-4">
                <i class="bi bi-speedometer2"></i> Admin Dashboard
            </h1>
            
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i>
                Welcome to the admin dashboard, <?= htmlspecialchars($userName) ?>!
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Quick Stats -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Members</h5>
                            <h2 class="mb-0">--</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people-fill fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Active Classes</h5>
                            <h2 class="mb-0">--</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-calendar-check fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Today's Bookings</h5>
                            <h2 class="mb-0">--</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-bookmark-check fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Trainers</h5>
                            <h2 class="mb-0">--</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-person-badge fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning-fill"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=members" 
                           class="btn btn-outline-primary">
                            <i class="bi bi-upload"></i> Import Members (XML)
                        </a>
                        <a href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=classes" 
                           class="btn btn-outline-success">
                            <i class="bi bi-upload"></i> Import Classes (XML)
                        </a>
                        <a href="/highstreetgym/controllers/content/xml_import_controller.php?prefill=schedules" 
                           class="btn btn-outline-info">
                            <i class="bi bi-upload"></i> Import Schedules (XML)
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history"></i> Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">No recent activity</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>