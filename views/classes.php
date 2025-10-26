<?php
$title   = "Class Timetable";
$headers = ['Day','Time','Class','Trainer'];
$rows    = [
  ['Day'=>'Monday','Time'=>'9:00 AM','Class'=>'Yoga','Trainer'=>'Alice'],
  ['Day'=>'Tuesday','Time'=>'5:00 PM','Class'=>'Pilates','Trainer'=>'John'],
];
$view = __DIR__ . '/classes.content.php';
include __DIR__ . '/layouts/base.php';