<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$configFile = __DIR__ . '/../../config.php';
if (file_exists($configFile)) {
    require_once $configFile;
} else {
    define('MONGO_URI', 'mongodb://localhost:27017');
    define('MONGO_DB', 'flouss');
}

function get_con_var()
{
    static $db = null;
    if ($db === null) {
        $client = new MongoDB\Client(MONGO_URI);
        $db = $client->{MONGO_DB};
    }
    return $db;
}
