<?php
// ADMIN LAYOUT CONTROLLER
require_once __DIR__ . '/base_layout.php';
$L = init_base_layout();
$L['bodyClass'] = 'admin-layout';
extract($L, EXTR_SKIP);

$title = $title ?? (($pageTitle ?? 'Admin') . ' - High Street Gym');
include __DIR__ . '/../../views/layouts/admin.php';