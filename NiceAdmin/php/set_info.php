<?php
    function insert_budget($connexion,$username,$salaire,$reste,$epargne){
        $connexion->budgets->insertOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }
    function set_budget($connexion,$salaire,$reste,$epargne,$username){
        $connexion->budgets->insertOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }
    function insert_depenses($connexion,$username,$nom,$description,$type,$prix,$q,$ddate){
        $connexion->depenses->insertOne([
            'username' => $username,
            'nom' => $nom,
            'description' => $description,
            'type' => $type,
            'prix' => (float)$prix,
            'quantite' => (int)$q,
            'ddate' => $ddate
        ]);
    }
    function set_bag($connexion,$username,$value,$jour){
        $connexion->bag->updateOne(
            ['username' => $username],
            ['$set' => ['value' => (float)$value, 'jour' => $jour]]
        );
    }
    function set_users($connexion,$username,$first_name,$last_name,$age,$passwrd,$date_payment){
        $connexion->users->updateOne(
            ['_id' => $username],
            ['$set' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'age' => (int)$age,
                'date_payment' => $date_payment
            ]]
        );
    }
    function insert_users($connexion,$username,$first_name,$last_name,$age,$passwrd,$date_payment){
        $connexion->users->insertOne([
            '_id' => $username,
            'passwrd' => password_hash($passwrd, PASSWORD_DEFAULT),
            'first_name' => $first_name,
            'last_name' => $last_name,
            'age' => (int)$age,
            'date_payment' => $date_payment
        ]);
    }
    function insert_bag($connexion,$username,$value,$jour){
        $connexion->bag->insertOne([
            'username' => $username,
            'value' => (float)$value,
            'jour' => $jour
        ]);
    }
?>