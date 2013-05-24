<?php

session_start ();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD ();

var_dump ($_POST['admin']);

foreach ($_POST['supprimer'] as $idadminprof)
    if ($idadminprof != 0)
        pg_query ($dbcon, requete_supprimer_prof ($idadminprof));
    
foreach ($_POST['admin'] as $idadminprof)
    pg_query ($dbcon, requete_prof_devient_admin ($idadminprof));

$resultatIdadmin = pg_query ($dbcon, "SELECT idadminprof FROM adminprofs WHERE admin = 'true' ORDER BY idadminprof;");
while ($arr = pg_fetch_array ($resultatIdadmin)) {
    $idadminFromBD = $arr['idadminprof'];
    echo $idadminFromBD;
    $valider = 'false';
    foreach ($_POST['admin'] as $idadminprof)
        if ($idadminprof == $idadminFromBD)
            $valider = 'true';
    if ($valider != 'true')
        pg_query ($dbcon, requete_admin_devient_prof ($idadminprof));
}


//        pg_query ($dbcon, requete_admin_devient_prof ($idadminprof));
header ('Location:./compte.php');
?>
