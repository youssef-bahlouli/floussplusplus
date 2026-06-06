<?php
require_once __DIR__ . '/database_connection.php';
function get_fullname($username){
    $db = get_con_var();
    $user = $db->users->findOne(['_id' => $username]);
    if($user){
        echo $user['first_name']." ".$user['last_name'];
    }
}
?>