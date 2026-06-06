<?php
function get_fullname($username){
    $host = 'localhost';
    $database = 'flouss';
    $user = 'ussef';
    $password = '123'; // Leave it empty
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$password");
    $line=pg_query($dbconn,"select * from users where username='$username'");
    $l=pg_fetch_assoc($line);
    echo $l['first_name']." ".$l['last_name'];
}

?>