<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Traitement publication</title>
        <link rel="stylesheet" href="../styles/theme.css" />
    </head>
    <body>
        <div id='page'>
            <?php
            session_start();
            date_default_timezone_set("Europe/Paris");
            if (!(isset($_SESSION["id"])) || ($_SESSION["statut"] == "etu")) {
                header('Location:../index.php');
            }
            if (!(isset($_GET["mode"])) || !(isset($_GET["idquiz"]))) {
                header('Location: publication.php');
            }

            // connexion à la BD
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
            $dbcon = connexionBDD();

            // Récup des variables
            $dateSession = time();
            $modeFonctionnement = $_GET["mode"];
            $mdpSession = $_GET["mdpSession"];
            $idquiz = $_GET["idquiz"];
            $etatsession = 1;

            // transmission des variables utiles à la page "supervision.php"
            $_SESSION["dateSession"] = $dateSession;
            $_SESSION["idquiz"] = $idquiz;
            $_SESSION["mode"] = $modeFonctionnement;
            $_SESSION["etatSession"] = $etatsession;



            // Créa de la session, en attente des élèves
            pg_query($dbcon, requete_creer_session($dateSession, $modeFonctionnement, $mdpSession, $idquiz, $etatsession)) or die("Echec de la requête");

            // rediriger vers supervision
            header('Location: supervision.php');
            ?>

        </div>
    </body>
</html>
