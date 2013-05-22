<?php

session_start ();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD ();

foreach ($_POST['supprimer'] as $idadminprof)
    if ($idadminprof != 0)
        pg_query ($dbcon, requete_supprimer_prof ($idadminprof));
foreach ($_POST['admin'] as $idadminprof)
        pg_query ($dbcon, requete_prof_devient_admin ($idadminprof));
header ('Location:./compte.php');
?>
