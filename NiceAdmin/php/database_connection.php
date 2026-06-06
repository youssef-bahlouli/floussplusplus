<?php
require_once __DIR__ . '/../../vendor/autoload.php';
function get_con_var(){
    $host = 'localhost';
    $database = 'flouss';
    $port = 27017;
    $client = new MongoDB\Client("mongodb://$host:$port");
    return $client->$database;
}
function docsToArray($cursor){
    $result = [];
    foreach ($cursor as $doc) {
        $arr = [];
        foreach ($doc as $key => $value) {
            if ($value instanceof MongoDB\BSON\ObjectId) {
                $arr[$key] = (string)$value;
            } elseif ($value instanceof MongoDB\BSON\UTCDateTime) {
                $arr[$key] = $value->toDateTime()->format('Y-m-d H:i:s');
            } else {
                $arr[$key] = $value;
            }
        }
        $result[] = $arr;
    }
    return $result;
}
function docToArray($doc){
    $arr = [];
    foreach ($doc as $key => $value) {
        if ($value instanceof MongoDB\BSON\ObjectId) {
            $arr[$key] = (string)$value;
        } elseif ($value instanceof MongoDB\BSON\UTCDateTime) {
            $arr[$key] = $value->toDateTime()->format('Y-m-d H:i:s');
        } else {
            $arr[$key] = $value;
        }
    }
    return $arr;
}
?>