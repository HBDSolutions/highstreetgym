<?php
// ADMIN LAYOUT CONTROLLER
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once __DIR__ . '/base_layout.php';

if (!function_exists('validate_layout_requirements')) {
    function validate_layout_requirements($pageTitle, $contentView) {
        if (empty($pageTitle))  die('MISSING $pageTitle');
        if (empty($contentView) || !file_exists($contentView)) die('INVALID $contentView');
    }
}
validate_layout_requirements($pageTitle ?? '', $contentView ?? '');

$title       = ($pageTitle ?? '') . ' - High Street Gym';
$layoutClass = 'admin-layout';

include __DIR__ . '/../../views/base.php';