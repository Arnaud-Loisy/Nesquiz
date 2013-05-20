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
            session_start();
            include '../accueil/menu.php';
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';

            $dbcon = connexionBDD();

            // Affiche la liste des admins et des profs
            echo"<br>
                <table>
                    <tr>
                        <td> Identifiant </td>
                        <td> Nom </td> 
                        <td> Prenom </td> 
                        <td> Admin </td> 
                        <td> Supprimer </td>
                    </tr>
                </table>";
            
            // Récupère l'identifiant, le nom et le prénom des admins et des profs
            $resultat = pg_query($dbcon,requete_tous_idadminprof_nomadminprof_prenomadminprof ());
            echo"<div class='scroll'>
                    <table class = 'border'>";
            while($arr = pg_fetch_array($resultat)){
                $nomadminprof=$arr["nomadminprof"];
                $prenomadminprof=$arr["prenomadminprof"];
                $idadminprof=$arr["idadminprof"];
                echo"<tr>
                        <td>".$idadminprof."</td>
                        <td>".$nomadminprof."</td>
                        <td>".$prenomadminprof."</td>
                        <td><input type='checkbox' name='admin' value='".$idadminprof."'></td>
                        <td><input type='checkbox' name='supprimer' value='".$idadminprof."'></td>
                    </tr>";
            }
            ?>
            </table>
            </div>
            <br>
            <input type='submit' name='Validé' value='validé'>
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
                            </select>  </td> </tr>
                </tr>
                    <td colspan=2 style ="text-align: center"> <input type="checkbox" name="admin" value="1"> Admin </td><br>
            </table>
            <input class="boutonCenter" value="Ajouter" type="submit">

            </form>
        </div>
    </body>
<html>
