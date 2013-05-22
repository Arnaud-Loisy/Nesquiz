<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Historique</title>
        <link rel="stylesheet" href="../styles/theme.css" />

    </head>

    <body>
        <div id='page'>
            <?php
            session_start();

            if (!(isset($_SESSION["id"])) || ($_SESSION["statut"] != "admin")) {
                header('Location:../index.php');
            }
            if (!(isset($_POST)))
                header('Location:historique.php');

            // connexion à la BD
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
            $dbcon = connexionBDD();

            //Supprimer l'ensemble des entrée avec l'id session en param
            foreach ($_POST['session'] as $dateSession) {

                pg_query($dbcon, requete_supprimer_session($dateSession)) or die("Echec de la requête");
            }

            $_SESSION["delSession"] = 1;

            header('Location:historique.php');
            ?> 
        </div>
    </body>
</html>