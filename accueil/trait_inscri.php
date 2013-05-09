<?php
session_start();
include '../admin/secret.php';
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
	echo "connection BDD succes <br>";

if((isset($_POST["nom"])) && (isset ($_POST["prenom"])) &&  (isset ($_POST["numero_etu"])) &&  (isset ($_POST["promotion"])) &&  (isset ($_POST["mdp"])) &&  (isset ($_POST["cmdp"])) && (isset ($_POST["langue"]))){

    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $numero_etu=$_POST["numero_etu"];
    $promotion=$_POST["promotion"];
    $mdp=$_POST["mdp"];
    $cmdp=$_POST["cmdp"];
    $langue=$_POST["langue"];
 
    $result_etu= pg_query($dbcon," SELECT idEtudiant FROM Etudiants WHERE idEtudiant =".$numero_etu);
        $arr = pg_fetch_array($result_etu);
 if ($arr==false){
     if($mdp==$cmdp){
          pg_query($dbcon,"INSERT INTO Etudiants VALUES (".$numero_etu.", '".$nom."', '".$prenom."', '".$mdp."', ".$promotion.", '".$langue."');");
             $_SESSION["nom"]=$_POST["nom"];
             $_SESSION["prenom"]=$_POST["prenom"];
             $_SESSION["statut"]="etu";
             $_SESSION["id"]=$_POST["numero_etu"];
         header('Location:./accueil.php');
     }
     else {
         $_SESSION["erreur_inscription_mdp"]=1;
         header('Location:./inscription.php');
     }
 }
 else{
       $_SESSION["erreur_inscription_numero_etu"]=1;
       header('Location:./inscription.php');
}
}
?>
