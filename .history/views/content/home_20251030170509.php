<!-- Home Content View -->
<div class="container mt-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-12 text-center">
            <h1 class="display-4 mb-3"><?= $welcomeMessage ?></h1>
            <p class="lead text-muted mb-4">
                Your journey to fitness starts here. Join our community and transform your life.
            </p>
            
            <?php if (!$isLoggedIn): ?>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="/highstreetgym/controllers/auth/register_controller.php" class="btn btn-success btn-lg px-4 gap-3">
                        <i class="bi bi-person-plus"></i> Join Now
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                </div>
            <?php else: ?>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="/highstreetgym/controllers/content/classes_controller.php" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-calendar-check"></i> Browse Classes
                    </a>
                    <a href="/highstreetgym/controllers/content/bookings_controller.php" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bi bi-bookmark-check"></i> My Bookings
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 text-center border-success">
                <div class="card-body">
                    <i class="bi bi-people-fill text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Expert Trainers</h5>
                    <p class="card-text">Work with certified professionals dedicated to your success.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 text-center border-success">
                <div class="card-body">
                    <i class="bi bi-calendar3 text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Flexible Schedule</h5>
                    <p class="card-text">Classes 7 days a week to fit your lifestyle.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 text-center border-success">
                <div class="card-body">
                    <i class="bi bi-heart-pulse-fill text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Varied Programs</h5>
                    <p class="card-text">From yoga to HIIT, find the perfect class for you.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-success text-white">
                <div class="card-body text-center p-5">
                    <h3 class="card-title mb-3">Ready to Start Your Fitness Journey?</h3>
                    <p class="card-text mb-4">Join hundreds of members already achieving their goals.</p>
                    <?php if (!$isLoggedIn): ?>
                        <a href="/highstreetgym/controllers/content/auth/register_controller.php" class="btn btn-light btn-lg">
                            <i class="bi bi-person-plus"></i> Sign Up Today
                        </a>
                    <?php else: ?>
                        <a href="/highstreetgym/controllers/content/classes_controller.php" class="btn btn-light btn-lg">
                            <i class="bi bi-calendar-check"></i> Book Your First Class
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>