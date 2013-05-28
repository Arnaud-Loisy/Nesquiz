<?php
session_start();
include '../admin/secret.php';
$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}else
	echo "connection BDD succes <br>";

if((isset($_POST["nom"])) && (isset ($_POST["prenom"])) &&  (isset ($_POST["numero_etu"])) &&  (isset ($_POST["promotion"])) &&  (isset ($_POST["mdp"])) &&  (isset ($_POST["cmdp"])) && (isset ($_POST["langue"]))){

    if (($_POST["nom"]!="") && ($_POST["prenom"]!="") && ($_POST["numero_etu"]!="") &&($_POST["promotion"]!="") && ($_POST["mdp"]!="") && ($_POST["cmdp"]!="") && ($_POST["langue"]!="")){
     
            if((strlen($_POST["nom"]) < 32 ) && (strlen($_POST["prenom"]) < 32) && (strlen($_POST["numero_etu"])< 32) && (strlen($_POST["promotion"])< 32) && (strlen($_POST["mdp"])< 32) && (strlen($_POST["cmdp"])< 32)){
    $nom=pg_escape_string($_POST["nom"]);
    $prenom=pg_escape_string($_POST["prenom"]);
    $numero_etu=pg_escape_string($_POST["numero_etu"]);
    $promotion=pg_escape_string($_POST["promotion"]);
    $mdp=pg_escape_string($_POST["mdp"]);
    $cmdp=pg_escape_string($_POST["cmdp"]);
    $langue=pg_escape_string($_POST["langue"]);
    $test_num_etu=(is_numeric($numero_etu));
    $test_promotion=(is_numeric($promotion));
    $mdph=md5($mdp);
    
    if($test_num_etu==true){
   
         if ($test_promotion==true){
      
    
    $result_etu= pg_query($dbcon," SELECT idEtudiant FROM Etudiants WHERE idEtudiant =".$numero_etu);
        $arr = pg_fetch_array($result_etu);
 if ($arr==false){
     if($mdp==$cmdp){
          pg_query($dbcon,"INSERT INTO Etudiants VALUES (".$numero_etu.", '".$nom."', '".$prenom."', '".$mdph."', ".$promotion.", '".$langue."');");
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
    else {
          $_SESSION["erreur_promotion"]=1;
        header('Location:./inscription.php');
    
    }
    }
    else {
        $_SESSION["erreur_num_etu"]=1;
        header('Location:./inscription.php');
    }
    }
    else { 
        if((strlen($_POST["nom"]) > 32 )){
        $_SESSION["erreur_longeur_champ_inscription_nom"]=1;
        header('Location:./inscription.php');
        }
        if(strlen($_POST["prenom"]) > 32){
        $_SESSION["erreur_longeur_champ_inscription_prenom"]=1;
        header('Location:./inscription.php');
        }
        if(strlen($_POST["numero_etu"]) > 32){
        $_SESSION["erreur_longeur_champ_inscription_etu"]=1;
        header('Location:./inscription.php');
        }
        if(strlen($_POST["promotion"]) > 32){
        $_SESSION["erreur_longeur_champ_inscription_promotion"]=1;
        header('Location:./inscription.php');
        }
        if(strlen($_POST["mdp"]) > 32){
        $_SESSION["erreur_longeur_champ_inscription_mdp"]=1;
        header('Location:./inscription.php');
        }
        if(strlen($_POST["cmdp"]) > 32){
        $_SESSION["erreur_longeur_champ_inscription_cmdp"]=1;
        header('Location:./inscription.php');
        }
        }
      }
    else {
        $_SESSION["erreur_inscription_incomplet"]=1;
        header('Location:./inscription.php');
    }
            }
            


?>
