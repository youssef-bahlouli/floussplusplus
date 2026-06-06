<?php
/*
    $current= new  DateTime();
    echo $current->format("Y-m-d H:i:s");
    require "get_info.php";
    $c=get_con_var();
    require "set_info.php";
    insert_depenses($c,"ussef11","suit","dqefegrg","produit",10,2,$current->format("Y-m-d H:i:s"));
*/

/*
    require 'get_info.php';
    require 'set_info.php';
    $connexion=  get_con_var();
    
    set_bag($connexion,'ussef11',0);

    session_start();
    $_SESSION['login']='ussef11';

    $bag=get_bag($_SESSION['username']);
    echo  $bag['value'];
*/
    $date = "2024-04-15";
    $new = "2024-05-14";
    $x= new DateTime();

    // Create DateTime objects for comparison
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    $newObj = DateTime::createFromFormat('Y-m-d', $new);

    // Check if the year and month of $new is greater than $date
    /*
    if ($newObj->format('Ym') > $dateObj->format('Ym')) {
        echo "A month has passed since $date.\n";
    } else {
        echo "A month has not passed since $date.\n";
    }
    */
    $username='ussef11';
    //$date_payment= new DateTime();
    //echo $date_payment->format('Y-m-d').'<br>';

    //$x= $date_payment->format('Y-m-d H:i:s');
    $x = "2024-3-14 21:34";

    require 'set_info.php';
    require 'get_info.php';
    $connexion=get_con_var();
    set_users($connexion,$username,'youssef','bahlouli','23','pass1',$x);

    //echo get_date_payment('ussef11');
    $date_payment=get_date_payment('ussef11');
    echo $date_payment."<br>";
    $today=  new DateTime();

    $new=$today->format('m');
    echo $new.'<br>';
    $old=intval(substr($date_payment,5,1));

    if($new > $old){
        echo "a month has passed";
    }





?>