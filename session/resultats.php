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
      
      // mettre session à l'état 3
      
      // récupérer datesession
     // $dateSession = $_SESSION["datesession"];
      $dateSession = 1;
      unset($_SESSION["datesession"]);
      
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
       
       $tabNotes = array();
       while($listeEtudiants = pg_fetch_array($res_listeEtudiants)){
           echo "<tr>";
           echo "<tr> <td> ".$listeEtudiants["nometudiant"]."</td> <td> ".$listeEtudiants["prenometudiant"]."</td>";
           
           $tabNotes=array($listeEtudiants["idetudiant"]=>array());
           
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
                echo "<br> nb rep justes questions :".$nbRepJustes[0];
                echo "<br>";
                
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
                 echo "nb rep fausse etu :".$nbRepFauxEtu[0];
                 echo "<br>";
                 
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
                
                 echo "nb rep totale etu :".$nbRepTotalEtu[0];
                 echo "<br>";
                 // Calculer la note de l'étudiant pour la question
                 if($nbRepFauxEtu[0]!=0)
                     $noteQuestion = 0;
                 else
                     $noteQuestion = $nbRepTotalEtu[0]/$nbRepJustes[0];
                     
                // Stocker la note
                 echo "question ".$listeQuestions["idquestion"]." : ".$noteQuestion."<br>";
                // $tabNotes[$listeEtudiants["idetudiant"]["'".$listeQuestions["idquestion"]."'"]]=$noteQuestion;

           }
           
           // calculer la note du quiz
           $scoreTotal=0;
           
           for($i=0;$i<$nbQuestions[0];$i++){
               echo "listing des scores :".$tabNotes[$listeEtudiants["idetudiant"][$i]]."<br>";
                $scoreTotal+=$tabNotes[$listeEtudiants["idetudiant"][$i]];
           }
           $noteQuiz=$scoreTotal/$nbQuestions[0];
           echo "Score total : ".$noteQuiz."<br>";
       }
       
    ?>
    </div>
</body>

</html>