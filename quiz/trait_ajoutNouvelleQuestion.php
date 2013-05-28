<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Traitement des questions</title>
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
            $idQuiz = pg_escape_string($_POST["idQuiz"]);
            $idQuestion = pg_escape_string($_POST["idQuestion"]);

            // transmission des variables utiles à la page "gestionquiz.php"
            //$_SESSION["nomQuiz"] = $nomQuiz;

            // Créa de la session, en attente des élèves
            pg_query($dbcon, requete_ajout_question_dans_quiz($idQuiz, $idQuestion));

            // rediriger vers supervision
            header('Location: gestionquiz.php');
            ?>

        </div>
    </body>
</html>
