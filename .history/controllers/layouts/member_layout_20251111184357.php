<?php
// MEMBER LAYOUT CONTROLLER

require_once __DIR__ . '/base_layout.php';
$L = init_base_layout();
$L['bodyClass'] = 'member-layout';
extract($L, EXTR_SKIP);

$title = $title ?? (($pageTitle ?? 'Member') . ' - High Street Gym');
include __DIR__ . '/../../views/layouts/member.php';