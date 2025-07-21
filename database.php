<?php
    $db_server = "localhost";
    /*$db_user = "c2bryan";
    $db_pass = "classe2018";
    $db_name= "c2sql";
    */
    $db_user = "root";
    $db_pass = "";
    $db_name= "mydb_Schema";
    $db_port= 3307;
    $conn = "";

    try{
        // Live
    /*$conn = Mysqli_connect($db_server, $db_user,
                             $db_pass, $db_name, $db_port);
                             */
    $conn = Mysqli_connect($db_server, $db_user,
                             $db_pass, $db_name, $db_port);
    }
    catch(mysqli_sql_exception){
        echo "could not connect !";
        /*
        echo $db_server . "<br>"; 
        echo $db_user  . "<br>";
        echo $db_name  . "<br>";
        echo $conn  . "<br>";
        */
    }
    if($conn)
    {
        //echo "You are connected to the server ! <br>";
    }


?>