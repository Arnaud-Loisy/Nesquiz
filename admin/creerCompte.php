<?php
session_start();
include '../admin/secret.php';
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
echo "connection BDD succes <br>";

if((isset($_POST["nom"])) && (isset ($_POST["prenom"])) && (isset ($_POST["identifiant"])) && (isset ($_POST["mdp"]))){

    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $identifiant=$_POST["identifiant"];
    $mdp=$_POST["mdp"];

    $mdph=md5($mdp);
    
}
