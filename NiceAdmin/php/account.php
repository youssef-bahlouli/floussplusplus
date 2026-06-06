<?php
function log_in($connexion,$username,$password)
    {
        $user = $connexion->users->findOne(['_id' => $username]);
        if(!$user) return 'User not found';
        if($user['passwrd']!=$password) return 'Incorrect password';
        $_SESSION['username'] = $username;
        return true;
    }
?>