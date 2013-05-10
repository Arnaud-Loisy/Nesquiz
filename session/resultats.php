<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Résultats de la session</title>
                <link rel="stylesheet" href="..\styles\theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
    <?php
      session_start();
      if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu") || !(isset($_SESSION["datesession"])) || !(isset($_SESSION["idquiz"]))){
        header('Location:../index.php');
      }
      include '../accueil/menu.php';
      include '../admin/secret.php';
      $dbcon = pg_connect("host=$host user=$login password=$password");
     
      // récupérer datesession
      //$dateSession = $_SESSION["datesession"];
      $dateSession = 1;
      unset($_SESSION["datesession"]);
      
    // mettre session à l'état 3
    /*  $request="UPDATE TABLE Sessions
              SET etatSession=3
              WHERE dateSession='".$dateSession."';"; 
      pg_query($dbcon,$request) or die("Echec de la requête");*/
            
      
      // récupérer liste des étudiants participant à la session
      $request="SELECT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant
	FROM Etudiants, Participe, Sessions
	WHERE Sessions.dateSession = Participe.dateSession
	AND Etudiants.idEtudiant = Participe.idEtudiant
	AND Sessions.dateSession = '".$dateSession."';";       
      $res_listeEtudiants = pg_query($dbcon,$request) or die("Echec de la requête");
      
        // récupérer nb questions du quiz
       $request="SELECT COUNT(*)
	FROM Questions, Inclu, Quiz
	WHERE	Questions.idQuestion = Inclu.idQuestion
	AND Quiz.idQuiz = Inclu.idQuiz
	AND Quiz.idQuiz ='".$_SESSION["idquiz"]."';"; 
       $res_nbQuestions = pg_query($dbcon,$request) or die("Echec de la requête");
       $nbQuestions = pg_fetch_array($res_nbQuestions);
       
       // récupérer la liste des questions du quiz
       $request="SELECT Questions.libelleQuestion, Questions.idQuestion
	FROM Quiz, Questions, Inclu
	WHERE Quiz.idQuiz = Inclu.idQuiz
	AND Questions.idQuestion = Inclu.idQuestion
	AND Quiz.idQuiz ='".$_SESSION["idquiz"]."';";
       $res_listeQuestions = pg_query($dbcon,$request) or die("Echec de la requête");
       
       // Calculer et afficher les notes
       $tabNotes = array();
       while($listeEtudiants = pg_fetch_array($res_listeEtudiants)){
           echo "<tr> <td> ".$listeEtudiants["nometudiant"]."</td> <td> ".$listeEtudiants["prenometudiant"]."</td>";
           
           $tabNotes=array($listeEtudiants["idetudiant"]=>array());
           $scoreTotal=0;
           
           // calculer la note pour chaque question
           while($listeQuestions = pg_fetch_array($res_listeQuestions)){                  
                
                // récupérer le nb de réponses justes pour la question
               $request="SELECT COUNT(*)
                FROM Reponses, Questions
                WHERE Reponses.idQuestion = Questions.idQuestion
                AND Reponses.valide=TRUE
        	AND Questions.idQuestion ='".$listeQuestions["idquestion"]."';";
                $res_nbRepJustes = pg_query($dbcon,$request) or die("Echec de la requête");
                $nbRepJustes = pg_fetch_array($res_nbRepJustes);
                
                // récupérer le nb de réponses fausses répondues par l'élève pour la question
                $request="  SELECT COUNT(*)
                            FROM Repond, Questions, Reponses, Sessions, Etudiants
                            WHERE Repond.idReponse = Reponses.idReponse
                            AND Repond.idQuestion = Questions.idQuestion
                            AND Repond.dateSession = Sessions.dateSession
                            AND Repond.idEtudiant = Etudiants.idEtudiant	
                            AND Etudiants.idEtudiant = '".$listeEtudiants["idetudiant"]."'
                            AND Sessions.dateSession = '".$dateSession."'
                            AND Questions.idQuestion = '".$listeQuestions["idquestion"]."'
                            AND Reponses.valide = FALSE;";
                 $res_nbRepFauxEtu = pg_query($dbcon,$request) or die("Echec de la requête");
                 $nbRepFauxEtu = pg_fetch_array($res_nbRepFauxEtu);
                 
                 // récupérer le nb de réponses totales répondues par l'élève pour la question
                $request="  SELECT COUNT(*)
                            FROM Repond, Questions, Reponses, Sessions, Etudiants
                            WHERE Repond.idReponse = Reponses.idReponse
                            AND Repond.idQuestion = Questions.idQuestion
                            AND Repond.dateSession = Sessions.dateSession
                            AND Repond.idEtudiant = Etudiants.idEtudiant	
                            AND Etudiants.idEtudiant = '".$listeEtudiants["idetudiant"]."'
                            AND Sessions.dateSession = '".$dateSession."'
                            AND Questions.idQuestion = '".$listeQuestions["idquestion"]."';";
                 $res_nbRepTotalEtu = pg_query($dbcon,$request) or die("Echec de la requête");
                 $nbRepTotalEtu = pg_fetch_array($res_nbRepTotalEtu);
                 
                 // Calculer la note de l'étudiant pour la question
                 if($nbRepFauxEtu[0]!=0)
                     $noteQuestion = 0;
                 else
                     $noteQuestion = $nbRepTotalEtu[0]/$nbRepJustes[0];
                     
                // Stocker la note
                 $tabNotes[$listeEtudiants["idetudiant"]["'".$listeQuestions["idquestion"]."'"]]=$noteQuestion;
                 
                 // Ajout au cumul de note
                 $scoreTotal+=$noteQuestion;
           }

           // Calcul de la note du quiz de l'étudiant
           $noteQuiz=$scoreTotal/$nbQuestions[0];
           
           // Afficher la note
           echo "<td> ". round($noteQuiz*100 , 0) ."<td></tr>";
       }
       
    ?>
    </div>
</body>

</html>