<?php

// LOGOUT HANDLER
// Destroys session and redirects to home


// Include auth controller
require_once __DIR__ . '/../../controllers/AuthController.php';

// Handle logout
handle_logout();

header('Location: ../../index.php');
exit;
?>