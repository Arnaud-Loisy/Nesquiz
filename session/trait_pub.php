<?php
    session_start();
    include '../admin/secret.php';
    $dbcon=pg_connect("host=$host user=$login password=$password");

    session_start();
    if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
        header('Location:../index.php');
    }
    include '../admin/secret.php';
    $dbcon = pg_connect("host=$host user=$login password=$password");
    
    $request = "";

?>
