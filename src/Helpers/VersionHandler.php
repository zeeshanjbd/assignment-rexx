<?php

namespace App\Helpers;

class VersionHandler
{
    /**
     * @param string $version
     * @return string
     */
    public static function getTimezoneByVersion(string $version): string
    {
        return version_compare($version, '1.0.17+60', '>=') ? 'UTC' : 'Europe/Berlin';
    }
}
