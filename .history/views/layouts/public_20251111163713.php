<?php
// PUBLIC LAYOUT BOOTSTRAP

declare(strict_types=1);

$pageTitle   = $pageTitle   ?? 'Home';
$contentView = $contentView ?? __DIR__ . '/../content/home.php';

$layout = [
  'currentUser'   => $currentUser ?? ['is_logged_in' => false, 'user_name' => '', 'user_type' => 'guest'],
  'showMemberNav' => false,
  'showAdminNav'  => false,
];

include __DIR__ . '/base.php';