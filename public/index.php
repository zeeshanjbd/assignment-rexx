<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Helpers/env_loader.php';

use App\Controllers\BookingController;

loadEnv(__DIR__ . '/../config/.env.dev');

$controller = new BookingController();
$controller->index();
