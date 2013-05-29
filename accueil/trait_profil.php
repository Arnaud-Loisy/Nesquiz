<?php
session_start();
include '../admin/secret.php';
include '../bdd/requetes.php';
include '../bdd/connexionBDD.php';
$dbcon = connexionBDD ();

if ((isset($_SESSION["statut"])) && ($_SESSION["statut"] == "etu")) { //si l'utilisateur est un étudiant.
    $id = $_SESSION["id"];
    $result_etu = pg_query($dbcon,requete_retour_langue_mdp_etu($id));
    $arr = (pg_fetch_array($result_etu));
    $langue = $arr["langueEtudiant"];
    $mdph = $arr["mdpetudiant"];
    // on lui affiche quelques information (nom, prénom, interface).

    if ((isset($_POST["oldmdp"])) && (isset($_POST["newmdp"])) && (isset($_POST["cnewmdp"]))) {
        $mdpnew = ($_POST["newmdp"]);
        $mdpold = ($_POST["oldmdp"]);
        $mdpcnew = ($_POST["cnewmdp"]);
        if ( $mdpnew!="" && $mdpold!="" && $mdpcnew!=""){
        $mdphcnew = md5($mdpcnew);
        $mdphold = md5($mdpold);
        $mdphnew = md5($mdpnew);
       
// si les mot de passes correspondent a l'ancien et entre eux on fait le changement dans la BDD
        if ($mdph == $mdphold) {
            if ($mdphcnew == $mdphnew) {
                pg_query($dbcon,requete_maj_mdp_etu($mdphnew, $id));
                $_SESSION["mdpchok"] = 1;
            } else {
                $_SESSION["mdpconffail"] = 1;
            }
        } else {
            $_SESSION["mdpfail"] = 1;
        }
    } else {
           if($mdpnew=="" && $mdpold=="" && $mdpcnew==""){
                if  (($_POST["langue"]=="fr")|| ($_POST["langue"]=="en")) {
                         $langue = $_POST["langue"];
           
                 //pg_query($dbcon, "UPDATE Etudiants SET langueEtudiant = '" . $langue . "' WHERE idEtudiant=" . $id);
             
                         $_SESSION["languechok"] =1;
                }
            }
            else {
                $_SESSION["mdpchfail"] = 1;
            }
    }
  }
  
      
 }
 // meme chose que pour l'étudiant mais cette fois c'est si l'utilisateur est un administrateur.
if (((isset($_SESSION["statut"])) && ($_SESSION["statut"] == "admin")) || ((isset($_SESSION["statut"])) && ($_SESSION["statut"] == "prof"))) {
    $id = $_SESSION["id"];
    $result_adm = pg_query($dbcon,requete_retour_langue_mdp_admin($id));
    $arr = (pg_fetch_array($result_adm));
    $langue = $arr["langueAdminProf"];
    $mdph = $arr["mdpadminprof"];
    echo "$mdph";
    // on lui affiche quelques information (nom, prénom, interface).

    if ((isset($_POST["oldmdp"])) && (isset($_POST["newmdp"])) && (isset($_POST["cnewmdp"]))) {
        $mdpnew = ($_POST["newmdp"]);
        $mdpold = ($_POST["oldmdp"]);
        $mdpcnew = ($_POST["cnewmdp"]);
        if ( $mdpnew!="" && $mdpold!="" && $mdpcnew!=""){
        $mdphcnew = md5($mdpcnew);
        $mdphold = md5($mdpold);
        $mdphnew = md5($mdpnew);
       
// si les mot de passes correspondent a l'ancien et entre eux on fait le changement dans la BDD
        if ($mdph == $mdphold) {
            if ($mdphcnew == $mdphnew) {
                pg_query($dbcon, requete_maj_mdp_admin($mdphnew, $id));
                $_SESSION["mdpchok"] = 1;
            } else {
                $_SESSION["mdpconffail"] = 1;
            }
        } else {
            $_SESSION["mdpfail"] = 1;
        }
    } else {
           if($mdpnew=="" && $mdpold=="" && $mdpcnew==""){
                if  (($_POST["langue"]=="fr")|| ($_POST["langue"]=="en")) {
                         $langue = $_POST["langue"];
           
                 //pg_query($dbcon, "UPDATE AdminProfs SET langueAdminprof = '" . $langue . "' WHERE idAdminprof=" . $id);
             
                         $_SESSION["languechok"] =1;
                }
            }
            else {
                $_SESSION["mdpchfail"] = 1;
            }
    }
  }
  
      
 }

header('Location:./profil.php');
?>
