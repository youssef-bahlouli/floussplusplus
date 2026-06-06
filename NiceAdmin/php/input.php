<?php
    function input_depenses($dbconn,$username,$nom,$description,$type,$prix,$q){
        require_once 'get_info.php';
        require_once 'set_info.php';
        $l=get_budget($username);
        $reste=$l['rest_du_cheque_final'];
        $epargne=$l['epargne'];
        $salaire=$l['salaire'];
        $total=$q*$prix;
        if($reste<=$total){
            $total-=$reste;
            $reste=0;
            $epargne-=$total;
        }else{
            $reste-=$total;
        }
        $budgetResult = $dbconn->budgets->insertOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        $dbconn->depenses->insertOne([
            'username' => $username,
            'nom' => $nom,
            'description' => $description,
            'type' => $type,
            'prix' => (float)$prix,
            'quantite' => (int)$q,
            'ddate' => (new DateTime())->format("Y-m-d H:i:s"),
            'budget_id' => $budgetResult->getInsertedId()
        ]);
    }
    function input_salaire($username,$salaire,$reste,$condition){
        require_once 'get_info.php';
        require_once 'set_info.php';
        $dbconn = get_con_var();
        $budget=get_budget($username);
        $epargne=0;
        if($budget) $epargne=$budget['epargne'];
        insert_budget($dbconn,$username,$salaire,$reste,$epargne);
    }
    function input_epargne($username,$epargne,$reponse){
        require_once 'get_info.php';
        require_once 'set_info.php';
        $connexion = get_con_var();
        $latest=get_budget($username);
        $reste=$latest['rest_du_cheque_final'];
        $salaire=$latest['salaire'];
        if($reponse=="yes"){
            $epargne+= $latest['epargne'];
        }
        insert_budget($connexion,$username,$salaire,$reste,$epargne);
    }
    function input_budget($connexion,$username,$salaire,$reste,$epargne){
        $budgets = $connexion->budgets;
        $budgets->insertOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }
?>