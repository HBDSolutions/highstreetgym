<?php
// DIAG PUBLIC CONTROLLER
// PURPOSE: MINIMAL HANDOFF TO PUBLIC LAYOUT WITH A KNOWN VIEW

// START SESSION
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// REQUIRED VIEW VARIABLES
$pageTitle   = 'Diag Public';
$contentView = __DIR__ . '/../../views/content/_diag_public.php';

// REQUIRE PUBLIC LAYOUT CONTROLLER
require __DIR__ . '/../layouts/public_layout.php';
