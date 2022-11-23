<?php

    $dbservername = 'sql104.epizy.com';
    $dbusername = 'epiz_32655932';
    $dbpassword = 'gW3dNylfgyK';
    $dbname = "epiz_32655932_skycrown";
    $connection = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
    $connection->set_charset("utf8");
    

    // Check connection
    if(!$connection){
        die('Database connection error : ' .mysql_error());
    }
    
?>