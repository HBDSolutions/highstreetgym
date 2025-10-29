<?php

// LOGOUT HANDLER
// Destroys session and redirects to home


// Include auth controller
require_once __DIR__ . '/AuthController.php';

// Handle logout
handle_logout();

// Redirect to home page after logout
header('Location: ../index.php');
exit;
?>