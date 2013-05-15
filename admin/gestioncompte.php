<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href="../styles/theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Accueil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div id="page">
        <?php
        session_start();
        include '../accueil/menu.php';
        ?>
        <form action='creerCompte.php' method='POST'>
        En travaux comme le cul d'antho
        <table>
            <tr>
                <td>Nom</td> <td> <input name="nom" type="text" > </td> </tr>
            <tr>
                <td>Prénom</td> <td> <input name="prenom" type="text" > </td> </tr>
            <tr>
                <td>Identifiant</td> <td> <input name="identifiant" type="text" > </td> </tr>
            <tr>
                <td>Mot de passe</td> <td> <input name="mdp" type="text" > </td> </tr>
        </table>
        <input class="bouton" value="Ajouter" type="submit">
        </form>
    </div>
</body>

<html>
