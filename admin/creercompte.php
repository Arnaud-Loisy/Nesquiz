<?php

session_start();
include '../admin/secret.php';

$dbcon=pg_connect("host=$host user=$login password=$password");

if((isset($_POST["nom"])) && (isset ($_POST["prenom"])) && (isset ($_POST["identifiant"])) && (isset ($_POST["mdp"]))){

    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $identifiant=$_POST["identifiant"];
    $mdp=$_POST["mdp"];
    $langue=$_POST["langue"];
    $admin=$_POST["admin"];
    // Changement en boléen pour la base de donnée
    if($admin == 1)
            $adminb = "true";
    else
            $adminb = "false";
    
    $mdph=md5($mdp);
    
    $requetteCreerCompte1=" SELECT idAdminProf 
                                         FROM AdminProfs 
                                         WHERE idAdminProf =".$identifiant;
    
    $result_adminprof= pg_query($dbcon,$requetteCreerCompte1);
    
        $arr = pg_fetch_array($result_adminprof);
    if ($arr==false){
         $requetteCreerCompte2="INSERT INTO AdminProfs VALUES (".$identifiant.", '".$nom."', '".$prenom."','".$mdph."','".$adminb."','".$langue."');";
         pg_query($dbcon,$requetteCreerCompte2);
         header('Location:./compte.php');
    }
}
?>
