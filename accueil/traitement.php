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
	
	$result_etu= pg_query($dbcon, "SELECT idetudiant, mdpetudiant, nometudiant, prenometudiant FROM etudiants;");
        $arr = pg_fetch_array($result_etu);
        $result_adm = pg_query($dbcon, "SELECT idadminprof, mdpadminprof, admin, nomadminprof, prenomadminprof FROM adminprofs;");
        $tab = pg_fetch_array($result_adm);
        var_dump($arr);
        var_dump($tab);
	if($_POST["login"]==$arr["idetudiant"] && $_POST["mdp"]==$arr["mdpetudiant"]){
            $_SESSION["id"] = $_POST["login"];
            $_SESSION["statut"]="etu";
            $_SESSION["nom"]=$arr["nometudiant"];
            $_SESSION["prenom"]=$arr["prenometudiant"];
           
		//header("Location:./accueil.php");
	}
	else{if($_POST["login"]==$tab["idadminprof"] && $_POST["mdp"]==$tab["mdpadminprof"]){
		$_SESSION["id"] = $_POST["login"];
                $_SESSION["nom"]=$tab["nomadminprof"];
                $_SESSION["prenom"]=$tab["prenomadminprof"];
                
                if($tab["admin"]==t){
                $_SESSION["statut"] = "admin";}
                else{
                   $_SESSION["statut"]="prof";
                }
		//header('Location:./accueil.php');
	}
        
        else {
		$_SESSION["erreur_log"]=1;
                 
		//header('Location:./accueil_non_co.php');
	}
        }
}
 ?>

</body>

</html>