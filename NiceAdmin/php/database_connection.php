<?php
     function get_con_var(){
        $host = 'localhost';
        $database = 'flouss';
        $user = 'ussef';
        $password = '123'; // Leave it empty
        return pg_connect("host=$host dbname=$database user=$user password=$password");
    }
?>