<?php
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/services/LogService.php';
function log_in($connexion,$username,$password)
    {
        $user = (new UserRepository())->findByUsername($username);
        if(!$user) return 'User not found';
        if(!password_verify($password, $user['passwrd'])) return 'Incorrect password';
        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        log_action($username, 'login', 'Login successful');
        return true;
    }
?>
