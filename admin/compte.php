<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href="../styles/theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Gestion des Compte</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div id="page">
        <?php
        session_start();
        include '../accueil/menu.php';
        include '../admin/secret.php';
        
        $dbcon = pg_connect("host=$host user=$login password=$password");
       
        $resultat = pg_query($dbcon,"SELECT nomadminprof,prenomadminprof
                           FROM AdminProfs");
        echo"<br><table>";
        while($arr = pg_fetch_array($resultat)){
            echo"<tr><td>".$arr["nomadminprof"]."</td><td>".$arr["prenomadminprof"]."</td></tr>";
        }
        echo"</table>";
        ?>
        <form action='creercompte.php' method='POST'>
        <br>
        Créer compte enseignant
        <table>
            <tr>
                <td>Nom</td> <td> <input name="nom" type="text" > </td> </tr>
            <tr>
                <td>Prénom</td> <td> <input name="prenom" type="text" > </td> </tr>
            <tr>
                <td>Identifiant</td> <td> <input name="identifiant" type="text" > </td> </tr>
            <tr>
                <td>Mot de passe</td> <td> <input name="mdp" type="text" > </td> </tr>
            <tr>
        	<td>Langue de l'interface :</td> <td> <select name="langue"> 
                        <option value='fr'>Français</option>
                        <option value='en'>English</option>
                        </select>  </td> </tr>
            </tr>
                <td colspan=2 style ="text-align: center"> <input type="checkbox" name="admin" value="1"> Admin </td><br>
        </table>
        <input class="bouton" value="Ajouter" type="submit">
        
        </form>
    </div>
</body>

<html>
