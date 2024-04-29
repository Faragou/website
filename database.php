<?php
    $db_server = "sql113.infinityfree.com";
    $db_username = "if0_36273703";
    $db_password = "sOjePesz7i";
    $db_database = "if0_36273703_adatok";

    try{
        $connection = mysqli_connect($db_server, $db_username, $db_password, $db_database);
    }
    catch(mysqli_sql_exception){
        echo "Could not connect to database! <br>";
    }
    
?>