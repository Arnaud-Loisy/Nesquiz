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
        <br> 
        
        
    <?php
      session_start();
      if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu") || !(isset($_SESSION["datesession"])) || !(isset($_SESSION["idquiz"]))){
        header('Location:../index.php');
      }
      include '../accueil/menu.php';
      include '../admin/secret.php';
      include 'fonctions_resultats.php';
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
             
        // Calculer et afficher les notes  
       echo "<tr> <td> Nom </td> <td> Prénom </td> <td> Note </td> </tr>";
       $tabNotes = array();
       while($listeEtudiants = pg_fetch_array($res_listeEtudiants)){
           $idEtu = $listeEtudiants["idetudiant"];
           $nomEtu = $listeEtudiants["nometudiant"];
           $prenomEtu = $listeEtudiants["prenometudiant"];
           
           echo "<table>";
           echo "<tr> <td> ".$nomEtu."</td> <td> ".$prenomEtu."</td> ";
          
           // Stocker la note pour chaque question, pour chaque élève dans un tableau
           $tabNotes=array($idEtu=>array());
           while($listeQuestions = pg_fetch_array($res_listeQuestions)){                    
               $idQuestion=$listeQuestions["idquestion"];
               $tabNotes[$idEtu["'".$idQuestion."'"]]=calculNoteQuestion($idEtu, $dateSession, $idquestion);
           }
           
           // Afficher la note du quiz
           echo "<td> ". round(calculNoteQuiz($idEtu, $dateSession)*100 , 2) ." % <td> </tr>";
       }
       echo "</table>";
    ?>
    </div>
</body>

</html>