<!doctype html>
<html>
		
<head>
    <link rel="stylesheet" href="..\styles\theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Traitement</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
include '../admin/secret.php';
session_start();
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
	echo "connection BDD succes <br>";


if((isset($_POST["login"])) && (isset ($_POST["mdp"]))){
	
	$result_etu= pg_query($dbcon, "SELECT idEtudiant, mdpEtudiant, nomEtudiant, prenomEtudiant FROM Etudiants;");
        $arr = pg_fetch_array($result_etu);
        $result_adm = pg_query($dbcon, "SELECT idAdminProf, mdpAdminProf, Admin, nomAdminProf, prenomAdminProf FROM AdminProfs;");
        $tab = pg_fetch_array($result_adm);
	if($_POST["login"]==$arr["idEtudiant"] && $_POST["mdp"]==$arr["mdpEtudiant"]){
            $_SESSION["id"] = $_POST["login"];
            $_SESSION["statut"]="etu";
            $_SESSION["nom"]=$arr["nomEtudiant"];
            $_SESSION["prenom"]=$arr["prenomEtudiant"];
		header("Location:./accueil.php");
	}
	else{if($_POST["login"]==$tab["idAdminProf"] && $_POST["mdp"]==$tab["mdpAdminProf"]){
		$_SESSION["id"] = $_POST["login"];
                $_SESSION["nom"]=$tab["nomAdminProf"];
                $_SESSION["prenom"]=$tab["prenomAdminProf"];
                if($tab["Admin"]==1){
                $_SESSION["statut"] = "admin";}
                else{
                   $_SESSION["statut"]="prof";
                }
		header('Location:./accueil.php');
	}
        
        else {
		echo "erreur de connexion";
                sleep(3);
                
		header('Location:./accueil_non_co.php');
	}
        }
}
 ?>

</body>

</html>