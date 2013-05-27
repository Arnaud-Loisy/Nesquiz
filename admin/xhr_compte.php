<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

$dbcon = connexionBDD ();

if ($_POST['utilisateur'] == "prof") {
    unset ($_SESSION["etudiant"]);
    $_SESSION['enseignant'] = 1;
    echo"
        <br>
        <form action='majcompte.php' method='POST'>
        <div class='scroll'>
            <table class='liste'>
                <thead>
                    <th class='identifiant'> Identifiant </th>
                    <th class='nom'> Nom </th> 
                    <th class='prenom'> Prenom </th> 
                    <th class='admin'> Admin </th> 
                    <th class='supprimer'> Supprimer </th>
                </thead>
                <tbody>";
    
    // Récupère l'identifiant, le nom et le prénom des admins et des profs
    $resultat = pg_query ($dbcon, requete_tous_idadminprof_nomadminprof_prenomadminprof ());
    
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
    echo"
                </tbody>
            </table>
        </div>
        <br>
        <input  class='boutonMAJ' value='Valider' type='submit'>";
}
else {
    unset ($_SESSION["enseignant"]);
    $_SESSION['etudiant'] = 1;
    echo"
        <br>
        <form action='majcompte.php' method='POST'>
            <div class='scroll'>
                <table class='liste'>
                    <thead>
                        <th class='identifiant'>N° Etudiant</th>
                        <th class='nom'>Nom</th>
                        <th class='prenom'>Prenom</th>
                        <th class='admin'>Promo</th>
                        <th class='supprimer'>Supprimer</th>
                    </thead>
                <tbody>";
    $resultat = pg_query ($dbcon, requete_tous_les_etudiants());
    while ($arr = pg_fetch_array ($resultat)) {
        $numero_etu = $arr['idetudiant'];
        $nom = $arr['nometudiant'];
        $prenom = $arr['prenometudiant'];
        $promo = $arr['promo'];
        echo"
            <tr>
                <td class='identifiant'>" .$numero_etu. "</td>
                <td class='nom'>" .$nom. "</td>
                <td class='prenom'>" .$prenom. "</td>
                <td class='admin'>".$promo. "</td>
                <td class='supprimer'><input type='checkbox' name='supprimer[]' value='" .$numero_etu. "'></td>
           </tr>";
    }
}
