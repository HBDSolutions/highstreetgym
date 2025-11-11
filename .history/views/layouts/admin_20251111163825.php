<?php
// ADMIN LAYOUT BOOTSTRAP

declare(strict_types=1);

$pageTitle   = $pageTitle   ?? 'Admin Home';
$contentView = $contentView ?? __DIR__ . '/../admin/dashboard.php';

$layout = [
  'currentUser'   => $currentUser ?? ['is_logged_in' => true, 'user_name' => '', 'user_type' => 'admin'],
  'showMemberNav' => true,
  'showAdminNav'  => true,
];

include __DIR__ . '/base.php';