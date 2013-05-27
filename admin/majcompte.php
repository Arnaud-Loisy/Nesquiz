<?php

session_start ();
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (!(isset ($_SESSION["id"])))
    header ('Location:../index.php');

$dbcon = connexionBDD ();
if (!$dbcon)
    echo "<br><br>connection échouée à la BDD<br>";
else {
    // Suppression de certains enseignants sauf 0
    foreach ($_POST['supprimer'] as $idadminprof)
        if ($idadminprof != '0')
            pg_query ($dbcon, requete_supprimer_prof ($idadminprof));
    // Certains enseignants deviennent admin    
    foreach ($_POST['admin'] as $idadminprof)
        pg_query ($dbcon, requete_prof_devient_admin ($idadminprof));

    $resultatIdadmin = pg_query ($dbcon, "SELECT idadminprof FROM adminprofs WHERE admin = 'true' ORDER BY idadminprof;");
    while ($arr = pg_fetch_array ($resultatIdadmin)) {
        $idadminFromBD = $arr['idadminprof'];
        $valider = 'false';
        foreach ($_POST['admin'] as $idadminprof)
            if ($idadminprof == $idadminFromBD)
                $valider = 'true';
        if ($valider != 'true' && $idadminFromBD != '0')
            pg_query ($dbcon, requete_admin_devient_prof ($idadminFromBD));
    }
    header ('Location:./compte.php');
}
?>
