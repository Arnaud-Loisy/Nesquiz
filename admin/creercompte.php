<?php

session_start ();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD ();

if ((isset ($_POST["nom"])) && (isset ($_POST["prenom"])) && (isset ($_POST["mdp"]))) {

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $identifiant = $nom . "." . $prenom;
    $mdp = $_POST["mdp"];
    $langue = $_POST["langue"];
    $admin = $_POST["admin"];
    // Changement en boléen pour la base de donnée
    if ($admin == 1)
        $adminb = "true";
    else
        $adminb = "false";

    $mdph = md5 ($mdp);

    $result_adminprof = pg_query ($dbcon, requete_tous_idadminprof ($identifiant));
    $arr = pg_fetch_array ($result_adminprof);

    if ($arr == false) {
        pg_query ($dbcon, requete_inserer_prof ($identifiant, $nom, $prenom, $mdph, $adminb, $langue));
    }
    else
        $_SESSION["erreur_creation"] = 1;
    header ('Location:./compte.php');
}
?>
