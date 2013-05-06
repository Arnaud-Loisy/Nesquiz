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
include 'admin/secret.php';
session_start();
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
	echo "connection BDD succes <br>";


if((isset($_POST["login"])) && (isset ($_POST["mdp"]))){
	
	$result_etu= pg_query($dbcon, "SELECT idEtudiant, mdpEtudiant
        FROM Etudiants;");
        $arr = pg_fetch_array($result_etu);
        $result_adm= pg_query($dbcon, "SELECT idAdminProf, mdpAdminProf, Admin,FROM AdminProfs;");
        $tab = pg_fetch_array($result_adm);
	if($_POST["login"]==$arr[0] && $_POST["mdp"]==$arr[1]){
            $_SESSION["id"] = $_POST["login"];
            $_SESSION["statut"]="etu";
          
		header("Location: http://nesquiz.fr/accueil.php");
	exit();}
	else{if($_POST["login"]==$tab[0] && $_POST["mdp"]==$tab[1]){
		$_SESSION["id"] = $_POST["login"];
                if($tab[2]==1){
                $_SESSION["statut"] = $tab[2];}
                else{
                   $_SESSION["statut"]="prof";
                }
		header("Location: http://nesquiz.fr/accueil.php");
	exit();}
        else {
		echo "erreur de connexion";
		header("Location: http://nesquiz.fr/index.php");
	}
}
?>

</body>

</html>