<?php
session_start();
include '../admin/secret.php';
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon)
    echo "connection BDD failed<br>";
else
    echo "connection BDD succes <br>";

if((isset($_POST["nom"])) && (isset ($_POST["prenom"])) && (isset ($_POST["identifiant"])) && (isset ($_POST["mdp"]))){

    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $identifiant=$_POST["identifiant"];
    $mdp=$_POST["mdp"];
    $langue=$_POST["langue"];
    $admin=$_POST["admin"];
    if($admin == 1)
            $adminb = "true";
    else
            $adminb = "false";
    
    $mdph=md5($mdp);
    
    $result_adminprof= pg_query($dbcon," SELECT idAdminProf 
                                         FROM AdminProfs 
                                         WHERE idAdminProf =".$identifiant);
        $arr = pg_fetch_array($result_adminprof);
    if ($arr==false){
        echo "Pas d'identifiant";
         pg_query($dbcon,"INSERT INTO AdminProfs VALUES (".$identifiant.", '".$nom."', '".$prenom."','".$mdph."','".$adminb."','".$langue."');");
         header('Location:./gestioncompte.php');
    }
    else
        echo "Il y a un identifiant";
}
?>