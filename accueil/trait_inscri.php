<?php
session_start();
include '../admin/secret.php';
include '../bdd/requetes.php';
include '../bdd/connexionBDD.php';
$dbcon=connexionBDD ();

// on verifie qu tout les variables sont SET.
if((isset($_POST["nom"])) && (isset ($_POST["prenom"])) &&  (isset ($_POST["numero_etu"])) &&  (isset ($_POST["promotion"])) &&  (isset ($_POST["mdp"])) &&  (isset ($_POST["cmdp"])) && (isset ($_POST["langue"]))){
// on vérifie que toutes les variable sont remplie.
    if (($_POST["nom"]!="") && ($_POST["prenom"]!="") && ($_POST["numero_etu"]!="") &&($_POST["promotion"]!="") && ($_POST["mdp"]!="") && ($_POST["cmdp"]!="") && ($_POST["langue"]!="")){
     // on vérifie que toutes les variables respectent bien la taille maximum de ces dernières.
            if((strlen($_POST["nom"]) < 32 ) && (strlen($_POST["prenom"]) < 32) && (strlen($_POST["numero_etu"])< 32) && (strlen($_POST["promotion"])< 32) && (strlen($_POST["mdp"])< 32) && (strlen($_POST["cmdp"])< 32)){
    $nom=pg_escape_string($_POST["nom"]); // on met les variable de POST dans des variables locale
    $prenom=pg_escape_string($_POST["prenom"]);// et on s'assure que les information données ne soit pas 
    $numero_etu=pg_escape_string($_POST["numero_etu"]);// interprétées dans la BDD pg_escape_string...
    $promotion=pg_escape_string($_POST["promotion"]);
    $mdp=pg_escape_string($_POST["mdp"]);
    $cmdp=pg_escape_string($_POST["cmdp"]);
    $langue=pg_escape_string($_POST["langue"]);
    $test_num_etu=(is_numeric($numero_etu));
    $test_promotion=(is_numeric($promotion));
    $mdph=md5($mdp);
    
    if($test_num_etu==true){
   
         if ($test_promotion==true){
      
    
    $result_etu= pg_query($dbcon,requete_verif_inscription_num_etu_pas_existant($numero_etu));
        $arr = pg_fetch_array($result_etu);
 if ($arr==false){
     if($mdp==$cmdp){
          pg_query($dbcon,requete_inscription_etudiant($numero_etu, $nom, $prenom, $mdph, $promotion, $langue));
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
