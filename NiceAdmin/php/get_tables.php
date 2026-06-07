<?php
    require_once __DIR__ . '/repositories/DepenseRepository.php';
    require_once __DIR__ . '/repositories/BudgetRepository.php';
    require_once __DIR__ . '/repositories/BagRepository.php';
    require_once __DIR__ . '/repositories/UserRepository.php';
    function get_depenses_table($connexion, $username){
        return (new DepenseRepository())->getAll($username);
    }
    function get_depenses_table_ord_occurr($connexion, $username){
        return (new DepenseRepository())->getAllOrderedByOccurrence($username);
    }
    function get_budget_table($connexion, $username){
        return (new BudgetRepository())->getAll($username);
    }
    function get_bag_table($connexion, $username){
        return (new BagRepository())->getAll($username);
    }
    function get_users_table($connexion){
        return (new UserRepository())->getAll();
    }
?>
