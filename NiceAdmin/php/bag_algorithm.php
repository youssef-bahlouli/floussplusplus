<?php
    require 'get_info.php';
    require 'set_info.php';
    $connexion=get_con_var();
    $username = $_POST['username1'];
    $l=get_budget($username);
    $reste=$l['rest_du_cheque_final'];
    $epargne=$l['epargne'];
    $salaire=$l['salaire'];
    $date= new DateTime();
    insert_bag($connexion,$username,$reste,$date->format('Y-m-d H:i:s'));
    $epargne+=$reste;
    insert_budget($connexion,$username,$salaire,$salaire,$epargne);
    echo "payment passé";
?>