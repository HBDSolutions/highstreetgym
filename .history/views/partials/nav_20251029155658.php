<?php
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    function active($needle, $path) { return str_ends_with($path, $needle) ? 'active' : ''; }
?>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <i class="bi bi-dumbbell"></i> High Street Gym
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="views/classes.php">Classes</a></li>
        <li class="nav-item"><a class="nav-link" href="views/blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="views/auth/login.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>