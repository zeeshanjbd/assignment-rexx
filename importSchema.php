<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Helpers/env_loader.php';

use App\Services\BookingImporter;

try {
    loadEnv(__DIR__ . '/config/.env.dev');
    $importer = new BookingImporter();
    $importer->import(__DIR__ .'/data/bookings.json');
    echo "Bookings successfully imported.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}