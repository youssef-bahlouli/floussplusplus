<?php
    function get_depenses_table($connexion,$username){
        $cursor = $connexion->depenses->find(
            ['username' => $username],
            ['sort' => ['_id' => -1]]
        );
        return docsToArray($cursor);
    }
    function get_depenses_table_ord_occurr($connexion,$username){
        $pipeline = [
            ['$match' => ['username' => $username]],
            ['$group' => ['_id' => '$nom', 'occurrences' => ['$sum' => 1]]],
            ['$sort' => ['occurrences' => -1, '_id' => 1]]
        ];
        $result = [];
        foreach ($connexion->depenses->aggregate($pipeline) as $doc) {
            $result[] = ['nom' => $doc['_id'], 'occurrences' => $doc['occurrences']];
        }
        return $result;
    }
    function get_budget_table($connexion,$username){
        $cursor = $connexion->budgets->find(
            ['username' => $username],
            ['sort' => ['_id' => 1]]
        );
        $result = [];
        foreach ($cursor as $doc) {
            $arr = docToArray($doc);
            $arr['Budget'] = $arr['epargne'] + $arr['rest_du_cheque_final'];
            $result[] = $arr;
        }
        return $result;
    }
    function get_bag_table($connexion,$username){
        $cursor = $connexion->bag->find(
            ['username' => $username],
            ['sort' => ['jour' => 1]]
        );
        return docsToArray($cursor);
    }
    function get_users_table($connexion){
        $cursor = $connexion->users->find(
            [],
            ['sort' => ['_id' => 1]]
        );
        return docsToArray($cursor);
    }
?>