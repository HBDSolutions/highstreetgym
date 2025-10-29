<?php

    // Include base controller to set up common variables
    require_once __DIR__ . '/controllers/basecontroller.php';

    $title = "Welcome to High Street Gym";
    $view  = __DIR__ . '/views/home.php';
    include __DIR__ . '/views/layouts/base.php';