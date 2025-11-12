<?php
// PUBLIC LAYOUT

$viewVars = [
  'title'       => $pageTitle ?? 'High Street Gym',
  'contentView' => $contentView ?? ''
];
include __DIR__ . '/base.php';