<?php

    function input_depenses($dbconn,$username,$nom,$description,$type,$prix,$q){
        //get_info.php is a file that contains functions of how to get certain data, 
        $date= new  DateTime();
        
        $ddate=$date->format("Y-m-d H:i:s");
        require 'set_info.php';

        //new record in table depenses 
        insert_depenses($dbconn,$username,$nom,$description,$type,$prix,$q,$ddate);
        //1-gathering info on budget 
        $l=get_budget($username);
        //fetching that one line to use the information
        $reste=$l['rest_du_cheque_final'];
        $epargne=$l['epargne'];
        $salaire=$l['salaire'];
        //echo "<br>-- reste "  .$reste  ."<br><br> ";
        //echo "<br>-- epargne ".$epargne."<br><br> ";

        //echo $reste;
        //
        //---------------algo d'application, meaning << le traitement de données >>
        $total=$q*$prix;
        if($reste<=$total){
            $total-=$reste;
            $reste=0;
            $epargne-=$total; 
            
        }else{
            $reste-=$total;
        }
        //---------------end of algo
        //echo "<br>-- total "  .$total  ."<br><br> ";
        //echo "<br>-- reste "  .$reste  ."<br><br> ";
        //echo "<br>-- epargne ".$epargne."<br><br> ";
        
        //inserting the updates on table : budget
        insert_budget($dbconn,$salaire,$reste,$epargne);

        $l=get_budget_seperate($username,$salaire,$reste,$epargne);
        //fetching that one line to use the information

        $reste=$l['rest_du_cheque_final'];
        $epargne=$l['epargne'];
        $salaire=$l['salaire'];
        //echo "result : ";
        //echo "<br>-- total "  .$total  ."<br><br> ";
        //echo "<br>-- reste "  .$reste  ."<br><br> ";
        //echo "<br>-- epargne ".$epargne."<br><br> ";

        //gathering data to activate relations 
        $budget=get_budget_seperate($username,$salaire,$reste,$epargne);
        $id_budget=$budget['id_budget'];
        
        $depenses=get_depenses($username);
        $id_depenses=$depenses['id_depenses'];
        //echo "<br><br><br> ".$id_depenses."<br><br><br> ";
        //echo "<br><br><br> budget ".$id_budget."<br><br><br> ";
        
        //activating relations by inserting into relation-tables
        
        pg_query($dbconn,
            "insert into utilisation(username,id_budget) values('$username','$id_budget')");
        pg_query($dbconn,
            "insert into dep_budget(id_budget,id_depenses) values('$id_budget','$id_depenses')");
        pg_query($dbconn,
            "insert into users_dep(username,id_depenses) values('$username','$id_depenses')");
        
    }
    function input_salaire($username,$salaire,$reste,$condition){
        //get_info.php is a file that contains functions of how to get certain data, 
        require 'get_info.php';
        require 'set_info.php';
        $dbconn = get_con_var();
        //
        //echo "<br>-- salaire "  .$salaire  ."<br><br> ";
        //echo "<br>-- reste "  .$reste  ."<br><br> ";
        //
        $budget=get_budget($username);
        $epargne=$budget['epargne'];
        insert_budget($dbconn,$salaire,$reste,$epargne);
        //get latest id of budget            
        $a=get_budget_seperate($username,$salaire,$reste,$epargne);
        $id_budget=$a['id_budget'];
        //echo $id_budget;
        //get the username 
        $username=$_SESSION['username'];
        //make queries
        $requette="insert into utilisation(id_budget,username) values ('$id_budget','$username')";
        //apply queries
        pg_query($dbconn,$requette);
    }
    function input_epargne($username,$epargne,$reponse){
        require 'get_info.php';
        require 'set_info.php';

        $connexion = get_con_var();
        $latest=get_budget($username);
        $reste=$latest['rest_du_cheque_final'];
        $salaire=$latest['salaire'];
        //echo "input=========<br>   epargne :".$epargne;
        //echo "<br> <br>";
        //
        //echo "Last line===========<br>   last line epargne :".$latest['epargne'];

        if($reponse=="yes"){
            
            $epargne+= $latest['epargne'];
            //echo "<br>";
            //echo "<br>";

        }
        //echo "result===========<br>   last line epargne :".$epargne." reste : ";
        //echo '<br>';
        insert_budget($connexion,$salaire,$reste,$epargne);
        
        $l=get_budget_seperate($username,$salaire,$reste,$epargne);
        $id_budget=$l['id_budget'];
        
        insert_utilisation($connexion,$id_budget,$username) ;

    }


    function input_budget($connexion,$username,$salaire,$reste,$epargne){
        $sql="
        insert into budget(salaire,rest_du_cheque_final,epargne)
        values
	    (4000,2000,30000);
	
	    into depenses(nom,description,prix,quantite,ddate,type)
	    values
	    ('begin','begin',0,1,'2024-02-20 16:30:01','service');
		
	    INSERT INTO utilisation (id_budget)
	    SELECT id_budget FROM budget order by id_budget desc limit 1 ;
	    update utilisation set username ='$username';

	    INSERT INTO users_dep (id_depenses)
	    SELECT id_depenses FROM depenses order by id_depenses desc limit 1;
	    update users_dep set username ='$username';
	
	
	    INSERT INTO dep_budget (id_depenses)
	
	    SELECT id_depenses FROM depenses order by id_depenses desc limit 1;
	    update dep_budget set id_budget=
	    (SELECT id_budget FROM budget order by id_budget desc limit 1);
                ";
                pg_query($connexion, $sql);
                    
    }

?>