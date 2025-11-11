<?php
// ADMIN LAYOUT

$title = ($pageTitle ?? 'Admin') . ' - High Street Gym';
$showMemberMenu = false;  // Admins shouldn’t see member shortcuts
$showAdminMenu  = true;
include __DIR__ . '/base.php';