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
            date_default_timezone_set("Europe/Paris");
            include '../accueil/menu.php';

            // connexion à la BD
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
            $dbcon = connexionBDD();

            echo "<h1> Historique des sessions </h1>";

            if (isset($_SESSION["delSession"])) {
                echo "<center>Session(s) supprimée(s) avec succès !<br><br></center>";
                unset($_SESSION["delSession"]);
            }

            // Selectionner les sessions triées de la plus récente à la plus ancienne
            $result_sessions = pg_query($dbcon, requete_liste_sessions_terminees()) or die("Echec de la requête");

            // Afficher la liste des sessions
            echo "<form method='POST' action='trait_historique.php'>";
            echo "<table style='margin: auto'>";
            echo "<tr><td> Quiz </td><td> Date </td><td> Heure </td><td> Supprimer </td></tr>";

            while ($arr = pg_fetch_array($result_sessions)) {
                $dateSession = $arr["datesession"];
                $libelleQuiz = $arr["libellequiz"];

                echo "<tr><td>" . $libelleQuiz . "</td><td>" . date('d/m/Y', $dateSession) . "</td><td>" . date('H:i:s', $dateSession) . "</td>";
                echo "<td><input type='checkbox' name='session[]' value='" . $dateSession . "'></td></tr>";
            }

            echo "</table>";
            echo "<input class='boutonCenter' type='Submit' value='Valider les changements'>";
            echo "</form>";
            ?>
        </div>
    </body>
</html>

