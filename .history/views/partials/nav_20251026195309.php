<?php
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    function active($needle, $path) { return str_ends_with($path, $needle) ? 'active' : ''; }
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/highstreetgym/index.php">High Street Gym</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= active('index.php', $path) ?: ($path === '/highstreetgym/' ? 'active' : '') ?>"
             href="/highstreetgym/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= active('views/classes.php', $path) ?>"
             href="/highstreetgym/views/classes.php">Classes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= active('views/blog.php', $path) ?>"
             href="/highstreetgym/views/blog.php">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= active('views/auth/login.php', $path) ?>"
             href="/highstreetgym/views/auth/login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>