<?php

function log_in($connexion,$username,$password)
    {
        require 'get_tables.php';
        $table=get_users_table($connexion);

        while( $i = pg_fetch_assoc($table)){
            if($i['username'] == $username){
            //echo "username found";
            if( check_if_data_is_correct($connexion,$username,$password)==1){
            ?>
            <a href="../NiceAdmin/dashboard.php">
                <button class="btn btn-primary">Go to Dashboard</button>
                </a>
            <?php
                }
            }   
        }
    }
 function check_if_data_is_correct($connexion,$username,$password){
    $sql = "select * from users where username = '$username'";
    $result = pg_query($connexion,$sql);
    $line = pg_fetch_assoc($result);
    if($line['passwrd']!=$password){
        echo '<br>the username '.$username.' exists but, the password is not correctly written<br>';
        echo '<a href="../NiceAdmin/pages-login.html"> <button class="btn btn-primary"> Go Back<button/> </a>';
        return 0;
    }
    return 1;
 } 
?>