<!-- Home Content View -->
<main class="container my-5">
    
    <header class="text-center mb-5">
        <h1 class="display-4"><?= $welcomeMessage ?></h1>
        <p class="lead">Your journey to fitness starts here!</p>
        
        <?php if ($showGuestButtons): ?>
            <div class="mt-4">
                <a href="/highstreetgym/controllers/auth/register_controller.php" class="btn btn-primary btn-lg me-2">
                    Join Now
                </a>
                <a href="/highstreetgym/controllers/auth/login_controller.php" class="btn btn-secondary btn-lg">
                    Login
                </a>
            </div>
        <?php endif; ?>
        
        <?php if ($showMemberButtons): ?>
            <div class="mt-4">
                <a href="/highstreetgym/controllers/content/classes_controller.php" class="btn btn-primary btn-lg me-2">
                    Browse Classes
                </a>
                <a href="/highstreetgym/controllers/content/bookings_controller.php" class="btn btn-primary btn-lg">
                    My Bookings
                </a>
            </div>
        <?php endif; ?>
    </header>
    
    <section class="row g-4 mb-5">
        <article class="col-md-4">
            <div class="card h-100 text-center">
                <img src="/highstreetgym/assets/img/trainers.jpg" class="card-img-top" alt="Expert Trainers">
                <div class="card-body">
                    <h2 class="h5">Expert Trainers</h2>
                    <p>Work with certified professionals dedicated to your success.</p>
                </div>
            </div>
        </article>
        
        <article class="col-md-4">
            <div class="card h-100 text-center">
                <img src="/highstreetgym/assets/img/flexible_schedule.jpg" class="card-img-top" alt="Flexible Schedule">
                <div class="card-body">
                    <h2 class="h5">Flexible Schedule</h2>
                    <p>Classes 7 days a week to fit your lifestyle.</p>
                </div>
            </div>
        </article>
        
        <article class="col-md-4">
            <div class="card h-100 text-center">
                <img src="/highstreetgym/assets/img/trainers.jpg" class="card-img-top" alt="Varied Programs">
                <div class="card-body">
                    <h2 class="h5">Varied Programs</h2>
                    <p>From yoga to HIIT, find the perfect class for you.</p>
                </div>
            </div>
        </article>
    </section>
    
</main>