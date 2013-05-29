<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Traitement des quiz</title>
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
            if (!(isset($_POST["nomQuiz"])) || !(isset($_GET["tempsQuiz"]))) {
                header('Location: gestionquiz.php');
            }

            // connexion à la BD
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
            $dbcon = connexionBDD();

            // Récup des variables
            $nomQuiz = pg_escape_string($_POST["nomQuiz"]);
            $tempsQuiz = pg_escape_string($_POST["tempsQuiz"]);
			
			if (($nomQuiz == "Ex:\"IPV6\"") || ($tempsQuiz == "Ex:\"200(secondes)\""))
				header('Location: gestionquiz.php');
			
            // transmission des variables utiles à la page "gestionquiz.php"
            //$_SESSION["nomQuiz"] = $nomQuiz;

            // Créa de la session, en attente des élèves
            pg_query($dbcon, requete_creer_quiz($nomQuiz, $tempsQuiz)) or die("Echec de la requête");

            // rediriger vers supervision
            header('Location: gestionquiz.php');
            ?>

        </div>
    </body>
</html>
