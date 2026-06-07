<?php
    require_once __DIR__ . '/repositories/BudgetRepository.php';
    require_once __DIR__ . '/repositories/DepenseRepository.php';
    require_once __DIR__ . '/repositories/UserRepository.php';
    require_once __DIR__ . '/repositories/BagRepository.php';
    function insert_budget($connexion,$username,$salaire,$reste,$epargne){
        (new BudgetRepository())->insert($username, $salaire, $reste, $epargne);
    }
    function set_budget($connexion,$salaire,$reste,$epargne,$username){
        (new BudgetRepository())->insert($username, $salaire, $reste, $epargne);
    }
    function insert_depenses($connexion,$username,$nom,$description,$type,$prix,$q,$ddate){
        $budget = (new BudgetRepository())->getLatest($username);
        $budgetId = $budget ? $budget['_id'] : null;
        (new DepenseRepository())->insert($username, $nom, $description, $type, $prix, $q, $budgetId, $ddate);
    }
    function set_bag($connexion,$username,$value,$jour){
        (new BagRepository())->upsert($username, $value, $jour);
    }
    function set_users($connexion,$username,$first_name,$last_name,$age,$passwrd,$date_payment){
        (new UserRepository())->update($username, $first_name, $last_name, $age, $date_payment);
    }
    function insert_users($connexion,$username,$first_name,$last_name,$age,$passwrd,$date_payment){
        (new UserRepository())->insert($username, $first_name, $last_name, $age, $passwrd, $date_payment);
    }
    function insert_bag($connexion,$username,$value,$jour){
        (new BagRepository())->insert($username, $value, $jour);
    }
?>
