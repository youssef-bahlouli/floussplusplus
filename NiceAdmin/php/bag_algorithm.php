<?php
    //echo 1;

    require 'get_info.php';
    require 'set_info.php';
    $connexion=get_con_var();
    $username = $_POST['username1'];
    //echo $username ;
    $l=get_budget($username);
    $reste=$l['rest_du_cheque_final'];
    $epargne=$l['epargne'];
    $salaire=$l['salaire'];

    $date= new DateTime();
    insert_bag($connexion,$username,$reste,$date->format('Y-m-d H:i:s'));
    $epargne+=$reste;
    insert_budget($connexion,$salaire,$salaire,$epargne);
    $d=get_budget_seperate($username,$salaire,$salaire,$epargne);
    $id_budget=$d['id_budget'];
    //echo '<br> id of budget '.$id_budget;
    insert_utilisation($connexion,$id_budget,$username);
    echo "payment passé";



?>