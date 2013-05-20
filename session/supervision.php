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
         
        if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu") ){
                header('Location:../index.php');
         }
         
         if((!(isset($_SESSION["idquiz"]))) || (!(isset($_SESSION["dateSession"]))) ||  (!(isset($_SESSION["mode"]))) ){
                header('Location: publication.php');
         }
        
        // connexion à la BD
        include '../accueil/menu.php';
        include '../bdd/connexionBDD.php';
        include '../bdd/requetes.php';
        $dbcon = connexionBDD();
        
        // Récupération des variables de session
         $modeFonctionnement=$_SESSION["mode"];
         $dateSession=$_SESSION["dateSession"];
         $etatsession=$_SESSION["etatSession"];
         $idQuiz=$_SESSION["idquiz"];
          
         // Récupérer nom du quiz
         $result=  pg_query($dbcon,requete_libelleQuiz($idQuiz)) or die("Echec de la requête");
         $arr=  pg_fetch_array($result);
         
         // Afficher entête
         echo "<h1>".$arr[0]."</h1><br>";        
         echo "<center>Session lancée le ".date('d/m/Y', $dateSession)." à ".date('H:i:s', $dateSession)."<br>";
         echo "<br>Etudiants participant à la session :</center>";
         echo "<br><table style='margin: auto'>";
         
                // si mode quiz entier
                if ($modeFonctionnement==2){
                    // si session en attente
                    if($etatsession==1){
                        echo "<tr> <td> Nom </td> <td> Prénom </td> </tr> ";
                        
                        // Récupération des étudiants participants
                        $result=pg_query($dbcon,  requete_etudiants_participants($dateSession)) or die("Echec de la requête");

                         // affichage des étudiants participants
                        while($arr = pg_fetch_array($result)){
                            echo "<tr> <td> ".$arr["nometudiant"]."</td> <td> ".$arr["prenometudiant"]." </td> </tr>";
                        }
                        echo "</table>";

                        // afficher bouton "Lancer le quiz"
                        echo "<form method='POST' action='trait_supervision.php'>";
                        echo "<input class='boutonCenter' type='submit' value='Lancer le quiz'>";
                        echo "</form>";
                        
                     }
                   
                    else {
                        // Récupération des étudiants participants
                        $result=pg_query($dbcon,  requete_etudiants_participants($dateSession)) or die("Echec de la requête");

                        // affichage des étudiants participants et nb questions auxquelles ils ont répondus
                        echo "<tr> <td> Nom </td> <td> Prénom </td> <td> Questions répondues </td> </tr> ";
                        while($arr = pg_fetch_array($result)){
                                $nomEtu =$arr["nometudiant"];
                                $prenomEtu=$arr["prenometudiant"];
                                $idEtu=$arr["idetudiant"];
                                echo "<tr> <td> ".$nomEtu."</td> <td> ".$prenomEtu." </td>";

                                 //Compter nombre de réponses de l'étudiant
                                 $result_nbRep=pg_query($dbcon,  requete_nb_questions_repondues_par_un_etudiant($dateSession, $idEtu)) or die("Echec de la requête");
                                 $nbRep=pg_fetch_array($result_nbRep);
                                 
                                 echo "<td> ".$nbRep[0]."</td> </tr>";       
                        }
                        echo "</table>";

                        // afficher bouton "Arreter"
                        echo "<form method='POST' action='resultatsSupervision.php'>";
                        echo "<input class='boutonCenter' type='submit' value='Arrêter le quiz'>";
                        echo "</form>";
                    }
                        
                }
                // si mode Question/question
                else
                {
                    echo "Mode Question par Question non implémenté <br>";
                    unset($_SESSION["mode"]);
                    unset($_SESSION["dateSession"]);
                    unset($_SESSION["etatSession"]);                   
                }

                // refresh automatique de la page
                header("refresh: 5; url=supervision.php");
        ?>
        </div>
    </body>
</html>
