<?php

// LOGOUT HANDLER
// Destroys session and redirects to home


// Include auth controller
require_once __DIR__ . '/../../controllers/AuthController.php';

// Handle logout
handle_logout();

// Note: handle_logout() function will redirect, so code below won't execute
// But just in case, add a fallback
header('Location: ../../index.php');
exit;
?>