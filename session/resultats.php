<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Résultats de la session</title>
                <link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
        <br> 
        
        
    <?php
      session_start();
      
      if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu") || !(isset($_SESSION["dateSession"]))){
        header('Location:../index.php');
      }
      
      include '../accueil/menu.php';
      include '../admin/secret.php';
      include 'fonctions_resultats.php';
      $dbcon = pg_connect("host=$host user=$login password=$password");
     
      // récupérer datesession
      $dateSession = $_SESSION["dateSession"];
      unset($_SESSION["dateSession"]);
      
    // mettre session à l'état 3
      $request="UPDATE Sessions
              SET etatSession=3
              WHERE dateSession='".$dateSession."';"; 
      pg_query($dbcon,$request) or die("Echec de la requête");
            
      // récupérer id du quiz correspondant à la session
            $request= "SELECT idquiz
                        FROM Sessions
                        WHERE dateSession='".$dateSession."';";
            $res_idquiz = pg_query($dbcon,$request) or die("Echec de la requête");
            $tab_idquiz = pg_fetch_array($res_idquiz);
            $idquiz=$tab_idquiz[0];
            
      // récupérer liste des étudiants participant à la session
      $request="SELECT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant
	FROM Etudiants, Participe, Sessions
	WHERE Sessions.dateSession = Participe.dateSession
	AND Etudiants.idEtudiant = Participe.idEtudiant
	AND Sessions.dateSession = '".$dateSession."';";       
      $res_listeEtudiants = pg_query($dbcon,$request) or die("Echec de la requête");
      
        // récupérer la liste des questions du quiz
             $request="SELECT Questions.libelleQuestion, Questions.idQuestion
                        FROM Quiz, Questions, Inclu
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz ='".$idquiz."';";
             $res_listeQuestions = pg_query($dbcon,$request) or die("Echec de la requête");
             
        // Calculer et afficher les moyennes des élèves
       echo "Moyenne de la session : ".moyenneSession($dateSession)." %<br>";
       echo "<tr> <td> Nom </td> <td> Prénom </td> <td> Note </td> </tr>";
       //$tabNotes = array();
       
       while($listeEtudiants = pg_fetch_array($res_listeEtudiants)){
           $idEtu = $listeEtudiants["idetudiant"];
           $nomEtu = $listeEtudiants["nometudiant"];
           $prenomEtu = $listeEtudiants["prenometudiant"];
           
           echo "<table>";
           echo "<tr> <td> ".$nomEtu."</td> <td> ".$prenomEtu."</td> ";
          
          /* // Stocker la note pour chaque question, pour chaque élève dans un tableau
           $tabNotesEtu=array($idEtu=>array());
           while($listeQuestions = pg_fetch_array($res_listeQuestions)){                    
               $idQuestion=$listeQuestions["idquestion"];
               $tabNotes[$idEtu["'".$idQuestion."'"]]=noteQuestion($idEtu, $dateSession, $idQuestion);
           }*/
           
           // Afficher la note du quiz
           echo "<td> ".noteSession($idEtu, $dateSession)." % <td> </tr>";
       }
       echo "</table>";
       
       
       
       // Calculer et afficher les moyennes des questions
       echo "Moyenne des questions :<br>";
       echo "<table>";
       echo "<tr> <td> Question </td> <td> Moyenne </td> </tr>";
  
       while($listeQuestions = pg_fetch_array($res_listeQuestions)){
           $libelleQuestion=$listeQuestions["libellequestion"];
           $idQuestion=$listeQuestions["idquestion"];
           echo "<tr> <td> ".$libelleQuestion."</td>";
          
           // Afficher la moyenne de la question
           echo "<td> ". moyenneQuestion($dateSession, $idQuestion)." % <td> </tr>";
       }
       echo "</table>";
    ?>
    </div>
</body>

</html>