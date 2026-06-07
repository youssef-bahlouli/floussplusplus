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
        $cursor = (new BudgetRepository())->getAll($username);
        $user = (new UserRepository())->findByUsername($username);
        $firstName = $user ? $user['first_name'] : '';
        $lastName = $user ? $user['last_name'] : '';
        $result = [];
        foreach ($cursor as $doc) {
            $doc['first_name'] = $firstName;
            $doc['last_name'] = $lastName;
            $reste = $doc['rest_du_cheque_final'] ?? 0;
            $epargne = $doc['epargne'] ?? 0;
            $doc['Budget'] = $reste + $epargne;
            $result[] = $doc;
        }
        return $result;
    }
    function get_bag_table($connexion, $username){
        return (new BagRepository())->getAll($username);
    }
    function get_users_table($connexion){
        return (new UserRepository())->getAll();
    }
?>
