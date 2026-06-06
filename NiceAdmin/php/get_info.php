<?php
    require_once __DIR__ . '/database_connection.php';
    function get_salaire($username){
        $db = get_con_var();
        $l = $db->budgets->findOne(
            ['username' => $username],
            ['sort' => ['_id' => -1]]
        );
        if ($l) echo $l['rest_du_cheque_final'];
    }
    function get_budget($username){
        $db = get_con_var();
        return $db->budgets->findOne(
            ['username' => $username],
            ['sort' => ['_id' => -1]]
        );
    }
    function get_budget_seperate($username,$salaire,$reste,$epargne){
        $db = get_con_var();
        return $db->budgets->findOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne
        ]);
    }
    function get_budget_2nd_last_record(){
        $db = get_con_var();
        $cursor = $db->budgets->find(
            [],
            ['sort' => ['_id' => -1], 'skip' => 1, 'limit' => 1]
        );
        $arr = iterator_to_array($cursor);
        return !empty($arr) ? current($arr) : null;
    }
    function get_depenses($username){
        $db = get_con_var();
        return $db->depenses->findOne(
            [],
            ['sort' => ['_id' => -1]]
        );
    }
    function get_depenses_latest($username){
        $db = get_con_var();
        return $db->depenses->findOne(
            [],
            ['sort' => ['_id' => -1]]
        );
    }
    function get_bag($username){
        $db = get_con_var();
        return $db->bag->findOne(['username' => $username]);
    }
    function get_date_payment($username){
        $db = get_con_var();
        $l = $db->users->findOne(['_id' => $username]);
        return $l ? $l['date_payment'] : null;
    }
?>