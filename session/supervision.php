<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Session en cours</title>
                <link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
        <?php
        session_start();
         if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu") ){
                header('Location:../index.php');
         }
         
         if((!(isset($_SESSION["idquiz"]))) || (!(isset($_SESSION["dateSession"]))) ||  (!(isset($_SESSION["mode"]))) ){
                header('Location: publication.php');
         }
          // connexion à la BD
            include '../admin/secret.php';
            $dbcon = pg_connect("host=$host user=$login password=$password");
   
         $modeFonctionnement=$_SESSION["mode"];
         $dateSession=$_SESSION["dateSession"];
         $etatsession=$_SESSION["etatSession"];
         $idquiz=$_SESSION["idquiz"];
          $request = "SELECT libelleQuiz 
                        FROM quiz
                        WHERE idquiz  = '".$idquiz."';";
          $result=pg_query($dbcon,$request) or die("Echec de la requête");
          $row=  pg_fetch_array($result);
         echo "<h1>".$row[0]."</h1><br>";        
         echo "<center>Session lancée le ".date('d/m/Y', $dateSession)." à ".date('H:i:s', $dateSession)."<br>";
         echo "<br>Etudiants participant à la session :</center>";
         echo "<br><table style='margin: auto'>";
         
                // si mode quiz entier
                if ($modeFonctionnement==2){
                    // si session en attente
                    if($etatsession==1){
                        echo "<tr> <td> Nom </td> <td> Prénom </td> </tr> ";
                        // Récupération des étudiants participants
                        $request = "SELECT DISTINCT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, COUNT(idQuestion)
                                    FROM Repond, Etudiants, Sessions, Participe
                                    WHERE Repond.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession = Participe.dateSession
                                    AND Participe.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession='".$dateSession."'
                                    GROUP BY Etudiants.nomEtudiant, Etudiants.prenomEtudiant;";
                        $result=pg_query($dbcon,$request) or die("Echec de la requête");

                        
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
                        $request = "SELECT DISTINCT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant
                                    FROM Repond, Etudiants, Sessions, Participe
                                    WHERE Repond.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession = Participe.dateSession
                                    AND Participe.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession='".$dateSession."'
                                    GROUP BY Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant;";
                        $result=pg_query($dbcon,$request) or die("Echec de la requête");

                        // affichage des étudiants participants et nb questions auxquelles ils ont répondus
                        
                        echo "<tr> <td> Nom </td> <td> Prénom </td> <td> Questions répondues </td> </tr> ";
                        while($arr = pg_fetch_array($result)){
                                $nomEtu =$arr["nometudiant"];
                                $prenomEtu=$arr["prenometudiant"];
                                $idEtu=$arr["idetudiant"];
                                echo "<tr> <td> ".$nomEtu."</td> <td> ".$prenomEtu." </td>";

                                 //Compter nombre de réponses de l'étudiant
                                 $request = "SELECT COUNT(idQuestion)
                                            FROM Repond, Etudiants, Sessions, Participe
                                            WHERE Repond.idEtudiant = Etudiants.idEtudiant
                                            AND Repond.dateSession = Sessions.dateSession
                                            AND Sessions.dateSession = Participe.dateSession
                                            AND Participe.idEtudiant = Etudiants.idEtudiant
                                            AND Sessions.dateSession='".$dateSession."'
                                            AND Etudiants.idEtudiant='".$idEtu."';";
                                 $result_nbRep=pg_query($dbcon,$request) or die("Echec de la requête");
                                 
                                 $nbRep=pg_fetch_array($result_nbRep);
                                 echo "<td> ".$nbRep[0]."</td> </tr>";
                                 
                                    
                        }
                        echo "</table>";

                        // afficher bouton "Lancer le quiz"
                        echo "<form method='POST' action='supervision_resultats.php'>";
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
                    /*
                    // récupérer la liste des élèves participants
                     $request="SELECT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant
                                FROM Etudiants, Participe, Sessions
                                WHERE Sessions.dateSession = Participe.dateSession
                                AND Etudiants.idEtudiant = Participe.idEtudiant
                                AND Sessions.dateSession = '".$dateSession."';";       
                    $res_listeEtudiants = pg_query($dbcon,$request) or die("Echec de la requête");

                    while($listeEtudiants = pg_fetch_array($res_listeEtudiants)){
                        $idEtu=$listeEtudiants["idetudiant"];
                            // récupérer le nb de réponses totales répondues par l'élève pour la question
                             $request="  SELECT COUNT(*)
                                         FROM Repond, Questions, Reponses, Sessions, Etudiants
                                         WHERE Repond.idReponse = Reponses.idReponse
                                         AND Repond.idQuestion = Questions.idQuestion
                                         AND Repond.dateSession = Sessions.dateSession
                                         AND Repond.idEtudiant = Etudiants.idEtudiant	
                                         AND Etudiants.idEtudiant = '".$listeEtudiants["idetudiant"]."'
                                         AND Sessions.dateSession = '".$dateSession."'
                                         AND Questions.idQuestion = '".$idQuestion."';";
                              $res_nbRepTotalEtu = pg_query($dbcon,$request) or die("Echec de la requête");
                              $nbRepTotalEtu = pg_fetch_array($res_nbRepTotalEtu);

                              // si l'élève a repondu à la question
                              if($nbRepTotalEtu[0]!=0){
                                  // calculer score

                                  // afficher score
                              }

                    }*/
                }

                

                // refresh automatique
                header("refresh: 5; url=supervision.php");

        ?>
        </div>
    </body>
</html>