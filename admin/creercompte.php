<?php

session_start();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD();

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
    
    $requetteCreerCompte1=requete_tous_idadminprof($idadminprof);
    $result_adminprof= pg_query($dbcon,$requetteCreerCompte1);
    
        $arr = pg_fetch_array($result_adminprof);
    foreach($_POST['supprimer'] as $idadminprof){
        pg_query($dbcon,requete_supprimer_prof($iadminprof));
    }
    
    if ($arr==false){
         $requetteCreerCompte2=requete_inserer_prof($identifiant,$nom, $prenom,$mdph,$adminb,$langue);
         pg_query($dbcon,$requetteCreerCompte2);
         header('Location:./compte.php');
    }
    header('Location:./compte.php');
}
?>
