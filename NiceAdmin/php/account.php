<?php
function log_in($connexion,$username,$password)
    {
        require 'get_tables.php';
        $table=get_users_table($connexion);
        foreach($table as $i){
            if($i['_id'] == $username){
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
    $user = $connexion->users->findOne(['_id' => $username]);
    if(!$user){
        echo '<br>User not found<br>';
        echo '<a href="../NiceAdmin/pages-login.html"> <button class="btn btn-primary"> Go Back<button/> </a>';
        return 0;
    }
    if($user['passwrd']!=$password){
        echo '<br>the username '.$username.' exists but, the password is not correctly written<br>';
        echo '<a href="../NiceAdmin/pages-login.html"> <button class="btn btn-primary"> Go Back<button/> </a>';
        return 0;
    }
    return 1;
 } 
?>