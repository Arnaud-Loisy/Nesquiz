<?php

session_start();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD();

foreach($_POST['supprimer'] as $idadminprof)
            pg_query($dbcon,requete_supprimer_prof($idadminprof));
header('Location:./compte.php');

?>
