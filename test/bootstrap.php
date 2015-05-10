<?php
ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

define('CLASS_DIR', realpath(__DIR__ . '/../src/lib/'));
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
spl_autoload_register(function($className)
    {
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        if (stream_resolve_include_path($fileName)) {
            include $fileName;
            return true;
        }
        return false;
    }
);
require_once 'vendor/autoload.php';