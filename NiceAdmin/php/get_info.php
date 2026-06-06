<?php
    function get_con_var(){
        $host = 'localhost';
        $database = 'flouss';
        $user = 'ussef';
        $password = '123'; // Leave it empty
        return pg_connect("host=$host dbname=$database user=$user password=$password");
    }
    function get_salaire($username){
        $dbconn = get_con_var();
        $sql= "
        select *  
	    from utilisation
	    inner join budget on budget.id_budget  = utilisation.id_budget
		inner join users on users.username  = utilisation.username
		where 
        utilisation.username='$username' 
        order by utilisation.id_budget desc limit 1
	    ";
        $res=pg_query($dbconn,$sql);
        $l=pg_fetch_assoc($res);
        echo $l['rest_du_cheque_final'];
    }
    function get_budget($username){
        $dbconn = get_con_var();
        $sql= "select *  
	    from utilisation
	    inner join budget on budget.id_budget  = utilisation.id_budget
		inner join users on users.username  = utilisation.username
		where 
        utilisation.username='$username' 
        order by utilisation.id_budget desc limit 1";
        $res=pg_query($dbconn,$sql);
        //echo $sql;
        return pg_fetch_assoc($res);
    }
    function get_budget_seperate($username,$salaire,$reste,$epargne){
        $dbconn = get_con_var();
        $sql= "select *  
	    from budget where salaire=$salaire
        and rest_du_cheque_final=$reste
        and epargne=$epargne order by id_budget desc limit 1
        ";
        $res=pg_query($dbconn,$sql);
        //echo $sql;
        return pg_fetch_assoc($res);
    }
    function get_budget_2nd_last_record(){
        $dbconn = get_con_var();
        $res=pg_query($dbconn,"select * from budget order by id_budget desc limit 1 offset 1");
         return pg_fetch_assoc($res);
        
    }
    function get_depenses($username){
        $dbconn = get_con_var();
        $res=pg_query($dbconn,"
        select * from depenses
        order by id_depenses desc limit 1
        "
        );
         return pg_fetch_assoc($res); 
    }
    function get_depenses_latest($username){
        $dbconn = get_con_var();
        $res=pg_query($dbconn,"select * from "
        );
         return pg_fetch_assoc($res); 
    }
    function get_bag($username){
        $dbconn = get_con_var();
        $res=pg_query($dbconn,"select * from bag where username='$username'");
         return pg_fetch_assoc($res);
    }
    //user info
    function get_date_payment($username){
        $dbconn = get_con_var();
        $res=pg_query($dbconn,"select * from users where username='$username'");
        $l=pg_fetch_assoc($res);
        return $l['date_payment'];
    }
?>