<?php

session_start ();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD ();
if (isset ($_SESSION['enseignant'])) {
    if ((isset ($_POST["nom"])) && (isset ($_POST["prenom"])) && (isset ($_POST["mdp"]))) {
        if (($_POST["nom"] != "") && ($_POST["prenom"] != "") && ($_POST["mdp"] != "")) {
            if ((strlen ($_POST["nom"]) < 32 ) && (strlen ($_POST["prenom"]) < 32) && (strlen ($_POST["mdp"]) < 32)) {
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

                if ($arr == false)
                    pg_query ($dbcon, requete_inserer_prof ($identifiant, $nom, $prenom, $mdph, $adminb, $langue));
                else
                    $_SESSION["erreur_creation"] = 1;
            }
            else {
                if ((strlen ($_POST["nom"]) > 32))
                    $_SESSION["erreur_longeur_champ_inscription_nom"] = 1;
                if (strlen ($_POST["prenom"]) > 32)
                    $_SESSION["erreur_longeur_champ_inscription_prenom"] = 1;
                if (strlen ($_POST["mdp"]) > 32)
                    $_SESSION["erreur_longeur_champ_inscription_mdp"] = 1;
            }
        }
    }
    else
        $_SESSION["erreur_inscription_incomplet"] = 1;
    header ('Location:./compte.php');
} else {
    if ((isset ($_POST["nom"])) && (isset ($_POST["prenom"])) && (isset ($_POST["num_etu"])) && (isset ($_POST["promo"])) && (isset ($_POST["mdp"])) && (isset ($_POST["langue"]))) {
        if (($_POST["nom"] != "") && ($_POST["prenom"] != "") && ($_POST["num_etu"] != "") && ($_POST["promo"] != "") && ($_POST["mdp"] != "") && ($_POST["langue"] != "")) {
            if ((strlen ($_POST["nom"]) < 32 ) && (strlen ($_POST["prenom"]) < 32) && (strlen ($_POST["num_etu"]) < 32) && (strlen ($_POST["promo"]) < 32) && (strlen ($_POST["mdp"]) < 32)) {
                $nom = pg_escape_string ($_POST["nom"]);
                $prenom = pg_escape_string ($_POST["prenom"]);
                $numero_etu = pg_escape_string ($_POST["num_etu"]);
                $promotion = pg_escape_string ($_POST["promo"]);
                $mdp = pg_escape_string ($_POST["mdp"]);
                $langue = pg_escape_string ($_POST["langue"]);
                $test_num_etu = (is_numeric ($numero_etu));
                $test_promotion = (is_numeric ($promotion));
                $mdph = md5 ($mdp);
                if ($test_num_etu == true) {

                    if ($test_promotion == true) {


                        $result_etu = pg_query ($dbcon, requete_verif_inscription_num_etu_pas_existant ($numero_etu));
                        $arr = pg_fetch_array ($result_etu);
                        if ($arr == false)
                            pg_query ($dbcon, requete_inscription_etudiant ($numero_etu, $nom, $prenom, $mdph, $promotion, $langue));
                        else
                            $_SESSION["erreur_creation"] = 1;
                    }
                    else
                        $_SESSION["erreur_promotion"] = 1;
                }
                else
                    $_SESSION["erreur_inscription_numero_etu"] = 1;
            }
            else {
                if ((strlen ($_POST["nom"]) > 32))
                    $_SESSION["erreur_longeur_champ_inscription_nom"] = 1;
                if (strlen ($_POST["prenom"]) > 32)
                    $_SESSION["erreur_longeur_champ_inscription_prenom"] = 1;
                if (strlen ($_POST["num_etu"]) > 32)
                    $_SESSION["erreur_longeur_champ_inscription_etu"] = 1;
                if (strlen ($_POST["promo"]) > 32)
                    $_SESSION["erreur_longeur_champ_inscription_promotion"] = 1;
                if (strlen ($_POST["mdp"]) > 32)
                    $_SESSION["erreur_longeur_champ_inscription_mdp"] = 1;
            }
        }
    }
    header ('Location:./compte.php');
}



