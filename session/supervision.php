<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Session en cours</title>
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

            if ((!(isset($_SESSION["idquiz"]))) || (!(isset($_SESSION["dateSession"]))) || (!(isset($_SESSION["mode"])))) {
                header('Location: publication.php');
            }

            // connexion à la BD
            include '../accueil/menu.php';
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
            $dbcon = connexionBDD();

            // Récupération des variables de session
            $modeFonctionnement = $_SESSION["mode"];
            $dateSession = $_SESSION["dateSession"];
            $etatsession = $_SESSION["etatSession"];
            $idQuiz = $_SESSION["idquiz"];

            // Récupérer nom du quiz
            $result = pg_query($dbcon, requete_libelleQuiz($idQuiz)) or die("Echec de la requête");
            $arr = pg_fetch_array($result);

            // Afficher entête
            echo "<h1>" . $arr[0] . "</h1><br>";


            // si mode quiz entier
            if ($modeFonctionnement == 2) {
                echo "<center>Session lancée le " . date('d/m/Y', $dateSession) . " à " . date('H:i:s', $dateSession) . "<br>";
                echo "<br>Etudiants participant à la session :</center>";
                echo "<br><table class='liste'  style='margin: auto' width=50%>";
                // si session en attente
                if ($etatsession == 1) {
                    echo "<thead><tr><th> Nom </th> <th> Prénom </th> </tr> </thead><tbody>";

                    // Récupération des étudiants participants
                    $result = pg_query($dbcon, requete_etudiants_participants($dateSession)) or die("Echec de la requête");

                    // affichage des étudiants participants
                    while ($arr = pg_fetch_array($result)) {
                        echo "<tr> <td> " . $arr["nometudiant"] . "</td> <td> " . $arr["prenometudiant"] . " </td> </tr>";
                    }
                    echo "</tbody></table>";

                    // afficher bouton "Lancer le quiz"
                    echo "<form method='POST' action='trait_supervision.php'>";
                    echo "<input class='boutonCenter' type='submit' value='Lancer le quiz'>";
                    echo "</form>";
                } else {
                    // Récupération des étudiants participants
                    $result = pg_query($dbcon, requete_etudiants_participants($dateSession)) or die("Echec de la requête");
                    $nbQuest=  pg_fetch_array(pg_query($dbcon,  requete_nb_questions_d_un_quiz($idQuiz)));
                    // affichage des étudiants participants et nb questions auxquelles ils ont répondus
                    echo "<table class='liste' style='margin: auto' width=50%><thead> <tr> <th> Nom </th> <th> Prénom </th> <th> Questions répondues /".$nbQuest[0]." </th> </tr></thead><tbody> ";
                    while ($arr = pg_fetch_array($result)) {
                        $nomEtu = $arr["nometudiant"];
                        $prenomEtu = $arr["prenometudiant"];
                        $idEtu = $arr["idetudiant"];
                        echo "<tr> <td> " . $nomEtu . "</td> <td> " . $prenomEtu . " </td>";

                        //Compter nombre de réponses de l'étudiant
                        $result_nbRep = pg_query($dbcon, requete_nb_questions_repondues_par_un_etudiant($dateSession, $idEtu)) or die("Echec de la requête");
                        $nbRep = pg_fetch_array($result_nbRep);

                        echo "<td> " . $nbRep[0] . "</td> </tr>";
                    }
                    echo "</tbody></table>";

                    // afficher bouton "Arreter"
                    echo "<form method='POST' action='resultatsSupervision.php'>";
                    echo "<input class='boutonCenter' type='submit' value='Arrêter le quiz'>";
                    echo "</form>";
                }
            }
            // si mode Question/question
            else {
                echo "<center>Mode Question par Question non implémenté. Redirection... </center><br>";
                unset($_SESSION["mode"]);
                unset($_SESSION["dateSession"]);
                unset($_SESSION["etatSession"]);
                unset($_SESSION["idquiz"]);
            }

            // refresh automatique de la page
            header("refresh: 5; url=supervision.php");

            ?>
        </div>
    </body>
</html>
