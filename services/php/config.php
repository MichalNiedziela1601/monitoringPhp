<?php

// Database credentials
define('DB_HOST', '185.38.227.246');
define('DB_USER', 'monitoring');
define('DB_PASS', 'mon!rop7A');
define('DB_NAME', 'ropczyce');

function connect()
{
    $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);

    if(mysqli_connect_errno($connect)){
        die("Failed to connect: ".mysqli_connect_error());
    }

    mysqli_set_charset($connect, "utf8");

    return $connect;
   }


?>
