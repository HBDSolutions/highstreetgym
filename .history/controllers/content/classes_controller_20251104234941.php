<?php
// CLASSES CONTROLLER
declare(strict_types=1);

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/class_functions.php';

$title = 'Class Schedule';

try {
    $schedule = getAllSchedules($conn);
} catch (Throwable $e) {
    $error = 'Failed to load schedule: ' . $e->getMessage();
    $schedule = [];
}

require __DIR__ . '/../../views/content/classes.php';
