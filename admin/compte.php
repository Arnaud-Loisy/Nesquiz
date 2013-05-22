<!doctype html>

<html>
    <head>
        <title>Gestion des Compte</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div id="page">
            <?php
            session_start ();
            include '../accueil/menu.php';
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';

            $dbcon = connexionBDD ();

            // Affiche la liste des admins et des profs
            echo"<br>
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
            echo"<form action='majcompte.php' method='POST'>
                    <div class='scroll'>
                        <table class = 'border'>";
            while ($arr = pg_fetch_array ($resultat)) {
                $nomadminprof = $arr["nomadminprof"];
                $prenomadminprof = $arr["prenomadminprof"];
                $idadminprof = $arr["idadminprof"];
                echo"<tr>
                        <td class='identifiant'>" . $idadminprof . "</td>
                        <td class='nom'>" . $nomadminprof . "</td>
                        <td class='prenom'>" . $prenomadminprof . "</td>";
                $resultatAdmin = pg_query ($dbcon, requete_si_admin ($idadminprof));
                $arrAdmin = pg_fetch_array ($resultatAdmin);
                $admin = $arrAdmin['admin'];
                if ($admin == 't')
                    echo"<td class='admin'><input type='checkbox' name='admin[]' value='admin_" . $idadminprof . "' checked></td>";
                else
                    echo"<td class='admin'><input type='checkbox' name='admin[]' value='" . $idadminprof . "' ></td>";

                echo"<td class='supprimer'><input type='checkbox' name='supprimer[]' value='" . $idadminprof . "'></td>
                    </tr>";
            }
            ?>
        </table>
    </div>
    <br>
    <input  class='bouton' value='Valider' type='submit'>
</form>
<form action='creercompte.php' method='POST'>
    <br>
    Créer compte enseignant
    <table>
        <tr>
            <td>Nom</td> 
            <td> <input name="nom" type="text" > </td> 
        </tr>
        <tr>
            <td>Prénom</td> 
            <td> <input name="prenom" type="text" > </td> 
        </tr>
        <tr>
            <td>Identifiant</td> 
            <td> <input name="identifiant" type="text" > </td> 
        </tr>
        <tr>
            <td>Mot de passe</td> <td> 
                <input name="mdp" type="text" > </td> 
        </tr>
        <tr>
            <td>Langue de l'interface :</td> <td> <select name="langue"> 
                    <option value='fr'>Français</option>
                    <option value='en'>English</option>
                </select>  </td>
        </tr>
        <tr>
            <td colspan=2 style ="text-align: center"> <input type="checkbox" name="admin" value="1"> Admin </td>
        </tr>
    </table>
    <input class="boutonCenter" value="Ajouter" type="submit">

</form>
</div>
</body>
<html>
