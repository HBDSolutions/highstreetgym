<?php
/**
 * Application Entry Point
 * Redirects to home controller
 */

// DEBUG DEV HELPERS — add while debugging, then remove before final submission
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Location: /highstreetgym/controllers/content/home_controller.php');
exit;
?>