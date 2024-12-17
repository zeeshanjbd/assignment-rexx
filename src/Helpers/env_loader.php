<?php

/**
 * @param string $envFilePath
 * @return void
 */
function loadEnv(string $envFilePath)
{
    if (!file_exists($envFilePath)) {
        throw new RuntimeException("Environment file not found at path: $envFilePath");
    }

    $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }

        $name = trim($parts[0]);
        $value = trim($parts[1]);

        if (!getenv($name)) {
            putenv("$name=$value");
        }
    }
}

