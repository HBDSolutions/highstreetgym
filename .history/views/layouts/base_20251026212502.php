<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title ?? 'High Street Gym') ?></title>

        <!-- All paths relative to /highstreetgym/ -->
        <base href="/highstreetgym/">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
                rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
                crossorigin="anonymous">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" 
                href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Local stylesheet -->
        <link rel="stylesheet" href="../assets/style.css">

        <!-- Bootstrap JS bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
    </head>

    <body>
        <?php include __DIR__ . '/../partials/header.php'; ?>

        <main class="container my-4">
            <?php if (!empty($view)) include $view; ?>
        </main>

        <footer class="mt-5">
            <?php include __DIR__ . '/../partials/footer.php'; ?>
        </footer>
    </body>

</html>
