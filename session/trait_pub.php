<?php
    session_start();
    include '../admin/secret.php';
    $dbcon=pg_connect("host=$host user=$login password=$password");

    session_start();
    if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
        header('Location:../index.php');
    }
    $dateSession=time();
    $modeFonctionnement=$_POST["mode"];
    $mdpSession=$_POST["mdpSession"];
    $idquiz=$_POST["idquiz"];
    $etatsession=1;
    
    include '../admin/secret.php';
    $dbcon = pg_connect("host=$host user=$login password=$password");
    
    $request = "INSERT INTO sessions VALUES ('".time()."','".$modeFonctionnement."','".$mdpSession."','".$idquiz."','".$etatsession."';";
    pg_query($dbcon,$request) or die("Echec de la requête");
    
    echo "Nous somme le".date('d/m/Y', $dateSession)." et il est ".date('H:i:s', $dateSession);
    echo "<br>";
    echo "En attente de connexion des étudiants";

?>
