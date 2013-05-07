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
          pg_query($dbcon,"INSERT INTO Etudiants VALUES ($numero_etu, $nom, $prenom, $mdp, $promo, $langue");
             $_SESSION["nom"]=$_POST["nom"];
             $_SESSION["prenom"]=$_POST["prenom"];
         header('Location:./accueil.php');
     }
     else {
         echo "Erreur:le mot de passe et sa confirmation sont différents";
         sleep(10);
         header('Location:./inscription.php');
     }
 }
 else{
   echo"Un compte avec ce numéro d'étudiant existe déjà";
   sleep(10);
    header('Location:./inscription.php');
}
}
?>
