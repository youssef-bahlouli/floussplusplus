<?php
    require "get_info.php";
    $connexion=get_con_var();
    $text="addd new line";
    /*
    $current = time();
    $formattedTime = date("H:i:s", $current);
    pg_query($connexion,"insert into activity (content,moment) values('$text','$formattedTime')");
    */
    while (true) {
        $current = time();
        $formattedTime = date("H:i:s", $current);
        pg_query($connexion,"insert into activity (content,moment) values('$text','$formattedTime')");
        sleep(3); // Sleep for 3 seconds
    }
?>


