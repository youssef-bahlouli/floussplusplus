<?php
require_once __DIR__ . '/../../vendor/autoload.php';

function get_con_var()
{
    static $db = null;
    if ($db === null) {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $db = $client->flouss;
    }
    return $db;
}
