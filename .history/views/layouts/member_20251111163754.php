<?php
// MEMBER LAYOUT

declare(strict_types=1);

$pageTitle   = $pageTitle   ?? 'Home';
$contentView = $contentView ?? __DIR__ . '/../content/home.php';

$layout = [
  'currentUser'   => $currentUser ?? ['is_logged_in' => true, 'user_name' => '', 'user_type' => 'member'],
  'showMemberNav' => true,
  'showAdminNav'  => false,
];

include __DIR__ . '/base.php';
