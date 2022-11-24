<?php
    $host = "localhost";
    $user = "jwor124";
    $pw = "aldnsrock125!";
    $db = "jwor124";
    $connect = new mysqli($host, $user, $pw, $db);
    $connect -> set_charset("utf8");
    if(mysqli_connect_errno()){
        echo "database connect false";
    } else {
        // echo "database connect true";
    }
?>