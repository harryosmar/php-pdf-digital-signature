<?php
declare(strict_types=1);

namespace App\DigitalSign\File;


class Path
{
    /**
     * @param string $gotoPath
     * @param string $paramBasePath
     * @return string
     */
    static function basePath(string $gotoPath = '', string $paramBasePath = '') : string
    {
        static $basePath;

        if (is_null($basePath)) {
            $basePath = $paramBasePath;
        }

        return $basePath . $gotoPath;
    }
}