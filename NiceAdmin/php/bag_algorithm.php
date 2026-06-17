<?php
    require 'get_info.php';
    require 'set_info.php';
    $connexion=get_con_var();
    $username = $_POST['username1'];
    $l=get_budget($username);
    if(!$l){ echo "No budget found"; exit; }
    $reste=$l['rest_du_cheque_final'];
    $epargne=$l['epargne'];
    $salaire=$l['salaire'];
    $date= new DateTime();
    insert_bag($connexion,$username,$reste,$date->format('Y-m-d H:i:s'));
    $epargne+=$reste;
    set_budget($connexion,$salaire,$salaire,$epargne,$username);
    echo "Payment processed";
?>