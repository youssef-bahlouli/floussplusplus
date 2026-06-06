<?php
    function get_depenses_table($connexion,$username){
        return pg_query($connexion,"
        select * from users_dep
		inner join depenses on users_dep.id_depenses = depenses.id_depenses  
		inner join users on users.username = users_dep.username  where users_dep.username = '$username'
        ");
    }
    function get_depenses_table_ord_occurr($connexion,$username){
        return pg_query($connexion,"
            SELECT depenses.nom, COUNT(*) AS occurrences
            FROM depenses 
            INNER JOIN users_dep ON users_dep.id_depenses = depenses.id_depenses 
            INNER JOIN users ON users.username = users_dep.username where users_dep.username='$username'
            GROUP BY depenses.nom
            ORDER BY occurrences DESC, depenses.nom;       
        ");
    }
    function get_budget_table($connexion,$username){
        return pg_query($connexion,"
        select
        users.username, first_name,last_name,
    	age, budget.id_budget,
	    salaire,rest_du_cheque_final,
	    epargne,epargne+rest_du_cheque_final as Budget
	    from utilisation
	    inner join users ON users.username=utilisation.username 
	    inner join budget ON budget.id_budget=utilisation.id_budget 
	    where utilisation.username='$username' 
	    order by utilisation.id_budget ;
        ");
    }
    function get_bag_table($connexion,$username){
        $sql="SELECT * FROM bag 
	        where username='$username'
	        order by jour ";
        return pg_query($connexion,$sql);
    }

    function get_users_table($connexion){
        return pg_query($connexion,"select * from users order by username asc");
    }    
?>