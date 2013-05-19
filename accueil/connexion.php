
<?php
session_start();
include '../admin/secret.php';

$trouver=false;
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
	echo "connection BDD succes <br>";


if((isset($_POST["login"])) && (isset ($_POST["mdp"]))){
	
	$result_etu= pg_query($dbcon, "SELECT idetudiant, mdpetudiant, nometudiant, prenometudiant FROM etudiants;");
        
       while($arr = pg_fetch_array($result_etu)){
           $mdphco=md5($_POST["mdp"]);
           if($_POST["login"]==$arr["idetudiant"] && $mdphco==$arr["mdpetudiant"]){
            $_SESSION["id"] = $_POST["login"];
            $_SESSION["statut"]="etu";
            $_SESSION["nom"]=$arr["nometudiant"];
            $_SESSION["prenom"]=$arr["prenometudiant"];
            $trouver=true;
		header("Location:./accueil.php");
       }
       }
        $result_adm = pg_query($dbcon, "SELECT idadminprof, mdpadminprof, admin, nomadminprof, prenomadminprof FROM adminprofs;");
       
        while($tab = pg_fetch_array($result_adm)){
           
       $mdphco=md5($_POST["mdp"]);
      if($_POST["login"]==$tab["idadminprof"] &&  $mdphco==$tab["mdpadminprof"]){
		$_SESSION["id"] = $_POST["login"];
                $_SESSION["nom"]=$tab["nomadminprof"];
                $_SESSION["prenom"]=$tab["prenomadminprof"];
                $trouver=true;
                if($tab["admin"]=="t"){
                    $_SESSION["statut"] = "admin";}
                else{
                    $_SESSION["statut"]="prof";
                }
		header('Location:./accueil.php');
	}
        
        
        }
	
	if(!$trouver){
        
	
		$_SESSION["erreur_log"]=1;
                 
		header('Location:../index.php');
	}
}

 ?>