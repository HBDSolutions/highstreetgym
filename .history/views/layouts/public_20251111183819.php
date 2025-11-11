<?php
// PUBLIC LAYOUT CONTROLLER
require_once __DIR__ . '/base_layout.php';
$L = init_base_layout();
$L['bodyClass'] = 'public-layout';
extract($L, EXTR_SKIP);

$title = $title ?? (($pageTitle ?? 'High Street Gym') . ' - High Street Gym');
include __DIR__ . '/../../views/layouts/public.php';