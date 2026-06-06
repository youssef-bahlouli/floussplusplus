<?php
    function insert_budget($connexion,$salaire,$reste,$epargne){   
        pg_query($connexion,"
        insert into budget(salaire,rest_du_cheque_final,epargne)
        values ('$salaire','$reste','$epargne');
        ");
        //echo "result of insert".$reste." ".$epargne."<br>";
    }
    function set_budget($connexion,$salaire,$reste,$epargne,$username){   
        pg_query($connexion,"update budget set salaire='$salaire',
                            rest_du_cheque_final='$reste' ,
                            epargne='$epargne'
                            ");
        //echo "result of insert".$reste."".$epargne."";
    }
    function insert_utilisation($connexion,$id_budget,$username){   
        $requette="insert into utilisation(id_budget,username) values ('$id_budget','$username')";
        //apply queries
        pg_query($connexion,$requette);
    }
    function insert_depenses($connexion,$username,$nom,$description,$type,$prix,$q,$ddate){   
        $res=pg_query($connexion,
        "insert into depenses (nom,description,type,prix,quantite,ddate) 
        values ('$nom','$description','$type','$prix','$q','$ddate')");
    }
    //setting data of automated transferring from budget.rest_du_cheque_final to 
    function set_bag($connexion,$username,$value,$jour){
        $res=pg_query($connexion,"update bag set value='$value' , jour='$jour' where username='$username'");
    }
    function set_users($connexion,$username,$first_name,$last_name,$age,$passwrd,$date_payment){
        $res=pg_query($connexion,"update users set 
         first_name='$first_name', last_name='$last_name', 
        age='$age', date_payment='$date_payment'
        where username='$username'");
    }
    function insert_users($connexion,$username,$first_name,$last_name,$age,$passwrd,$date_payment){
        $sql="
        insert into users(username,passwrd,first_name,last_name,age,date_payment) values
	    ('$username','$passwrd','$first_name','$last_name','$age','$date_payment');
        ";
        pg_query($connexion,$sql);
        
    }
    function insert_bag($connexion,$username,$value,$jour){
        pg_query($connexion,"
        insert into bag(username,value,jour)
        values ('$username','$value' ,'$jour' );
        ");
    }
?>