<?php
    require_once __DIR__ . '/database_connection.php';
    require_once __DIR__ . '/repositories/BudgetRepository.php';
    function get_salaire($username){
        $budget = (new BudgetRepository())->getLatest($username);
        return $budget ? $budget['rest_du_cheque_final'] : 0;
    }
    function get_budget($username){
        return (new BudgetRepository())->getLatest($username);
    }
    function get_depenses_latest($username){
        require_once __DIR__ . '/repositories/DepenseRepository.php';
        return (new DepenseRepository())->getLatest($username);
    }
    function get_bag($username){
        require_once __DIR__ . '/repositories/BagRepository.php';
        return (new BagRepository())->findByUsername($username);
    }
    function get_date_payment($username){
        require_once __DIR__ . '/repositories/UserRepository.php';
        return (new UserRepository())->getDatePayment($username);
    }
