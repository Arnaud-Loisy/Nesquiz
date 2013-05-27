<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD ();

if ($_POST['utilisateur'] == "prof") {
    echo"
        <br>
        <table class='border'>
            <tr>
                <td class='identifiant'> Identifiant </td>
                <td class='nom'> Nom </td> 
                <td class='prenom'> Prenom </td> 
                <td class='admin'> Admin </td> 
                <td class='supprimer'> Supprimer </td>
            </tr>
        </table>";
    // Récupère l'identifiant, le nom et le prénom des admins et des profs
    $resultat = pg_query ($dbcon, requete_tous_idadminprof_nomadminprof_prenomadminprof ());
    echo"
<form action='majcompte.php' method='POST'>
<div class='scroll'>
<table class = 'border'>";
    while ($arr = pg_fetch_array ($resultat)) {
        $nomadminprof = $arr["nomadminprof"];
        $prenomadminprof = $arr["prenomadminprof"];
        $idadminprof = $arr["idadminprof"];
        echo"
<tr>
<td class='identifiant'>" . $idadminprof . "</td>
<td class='nom'>" . $nomadminprof . "</td>
<td class='prenom'>" . $prenomadminprof . "</td>";
        $resultatAdmin = pg_query ($dbcon, requete_si_admin ($idadminprof));
        $arrAdmin = pg_fetch_array ($resultatAdmin);
        $admin = $arrAdmin['admin'];
        if ($admin == 't')
            echo"
                <td class='admin'><input type='checkbox' name='admin[]' value='" . $idadminprof . "' checked></td>";
        else
            echo"
                <td class='admin'><input type='checkbox' name='admin[]' value='" . $idadminprof . "' ></td>";

        echo"
            <td class='supprimer'><input type='checkbox' name='supprimer[]' value='" . $idadminprof . "'></td>
</tr>";
    }
}
else {
    echo"
        <br>
        <table class='border'>
            <tr>
                <td class='identifiant'> N° Etudiant </td>
                <td class='nom'> Nom </td> 
                <td class='prenom'> Prenom </td> 
                <td class='admin'> Admin </td> 
                <td class='supprimer'> Supprimer </td>
            </tr>
        </table>";
}
