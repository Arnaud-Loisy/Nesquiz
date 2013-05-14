<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Supervision d'une session</title>
                <link rel="stylesheet" href="..\styles\theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
        <?php
        session_start();
         if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu") ){
                header('Location:../index.php');
         }
         
         if(!(isset($_SESSION["idquiz"])) || !(isset($_SESSION["dateSession"])) || !(isset($_SESSION["mode"]))){
                header('Location: publication.php');
         }
            
         $modeFonctionnement=$_SESSION["mode"];
         $dateSession=$_SESSION["dateSession"];
         $etatsession=$_SESSION["etatSession"];
         unset($_SESSION["mode"]);
         unset($_SESSION["dateSession"]);
         
         // connexion à la BD
            include '../admin/secret.php';
            $dbcon = pg_connect("host=$host user=$login password=$password");
         
         echo "Session démarrée le ".date('d/m/Y', $dateSession)." à ".date('H:i:s', $dateSession)."<br>";
        
                // si mode quiz entier
                if ($modeFonctionnement==2){
                    if($etatsession==1){
                        echo "<form method='POST' action='supervision.php'>";
                        echo "<input class='bouton' type='submit' value='Demarrer'>";
                        echo "</form>";

                        // Récupération des étudiants participants et nb de questions auxquels ils ont répondus
                        $request = "SELECT DISTINCT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, COUNT(idQuestion)
                                    FROM Repond, Etudiants, Sessions, Participe
                                    WHERE Repond.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession = Participe.dateSession
                                    AND Participe.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession='".$dateSession."'
                                    GROUP BY Etudiants.nomEtudiant, Etudiants.prenomEtudiant;";
                        $result=pg_query($dbcon,$request) or die("Echec de la requête");

                        // affichage des étudiants participants et nb questions auxquelles ils ont répondus
                        echo "<tr> <td> Nom </td> <td> Prénom </td> </tr> ";
                        while($arr = pg_fetch_array($result)){
                           echo "<table>";
                           echo "<tr> <td> ".$arr["nometudiant"]."</td> <td> ".$arr["prenometudiant"]." </td> <td>";
                        }
                        echo "</table>";

                        // afficher bouton "Lancer le quiz"
                        echo "<form method='POST' action='supervision.php'>";
                        echo "<input class='bouton' type='submit' value='Lancer'>";
                        echo "</form>";
                    }
                    
                    else {
                        echo "<form method='POST' action='resultats.php'>";
                        echo "<input class='bouton' type='submit' value='Demarrer'>";
                        echo "</form>";

                        // Récupération des étudiants participants et nb de questions auxquels ils ont répondus
                        $request = "SELECT DISTINCT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, COUNT(idQuestion)
                                    FROM Repond, Etudiants, Sessions, Participe
                                    WHERE Repond.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession = Participe.dateSession
                                    AND Participe.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession='".$dateSession."'
                                    GROUP BY Etudiants.nomEtudiant, Etudiants.prenomEtudiant;";
                        $result=pg_query($dbcon,$request) or die("Echec de la requête");

                        // affichage des étudiants participants et nb questions auxquelles ils ont répondus
                        echo "<tr> <td> Nom </td> <td> Prénom </td> <td> nb questions </td> </tr> ";
                        while($arr = pg_fetch_array($result)){
                           echo "<table>";
                           echo "<tr> <td> ".$arr["nometudiant"]."</td> <td> ".$arr["prenometudiant"]." </td> <td>".$arr[2];
                        }
                        echo "</table>";

                        // afficher bouton "Lancer le quiz"
                        echo "<form method='POST' action='resultats.php'>";
                        echo "<input class='bouton' type='submit' value='Arrêter'>";
                        echo "</form>";
                    }
                        
                }
                // si mode Question/question
                /*else
                {
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

                    }
                }*/

                

                // refresh automatique
                header("refresh: 5; url=supervision.php");

        ?>
        </div>
    </body>
</html>