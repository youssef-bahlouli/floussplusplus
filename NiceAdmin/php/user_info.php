<?php
require_once __DIR__ . '/database_connection.php';
require_once __DIR__ . '/repositories/UserRepository.php';
function get_fullname($username){
    return (new UserRepository())->getFullName($username);
}
