<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Résultats de la session</title>
                <link rel="stylesheet" href="../styles/theme.css" />
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
       // connexion à la BD
        include '../bdd/connexionBDD.php';
        include '../bdd/requetes.php';
        $dbcon= connexionBDD();
        include 'fonctions_resultats.php';
      
      echo "<h1>Résultats du quiz</h1>";
      
        // récupérer datesession
      $dateSession = $_SESSION["dateSession"];
      unset($_SESSION["dateSession"]);
      
      // mettre la session à l'état 3
      pg_query($dbcon,  requete_changer_etat_session($dateSession, 3)) or die("Echec de la requête");
            
      // récupérer id du quiz correspondant à la session
      $res_idquiz = pg_query($dbcon,  requete_idQuiz_correspondant_session($dateSession)) or die("Echec de la requête");
      $tab_idquiz = pg_fetch_array($res_idquiz);
      $idQuiz=$tab_idquiz[0];
                  
      // récupérer la liste des questions du quiz
       $res_listeQuestions = pg_query($dbcon,  requete_toutes_questions_dans_quiz($idQuiz)) or die("Echec de la requête");
             
       // Calculer et afficher le classement des étudiants
       echo "<center>Moyenne de la session : ".moyenneSession($dateSession)." %<br><br>";
       echo "<center>Classement des étudiants<br><br></center>";
       echo "<table style='margin: auto'><tr><td> Rang </td> <td> Nom </td> <td> Prénom </td> <td> Note </td> </tr>";
      
       $classement=classementSession($dateSession);
       for($i=0; $i<count($classement);$i++){
           echo "<tr><td>".($i+1)."</td> <td>".$classement[$i]["nom"]."</td> <td>".$classement[$i]["prenom"]."</td><td>".$classement[$i]["note"]." %</td></tr>";
       }
       echo "</table><br>";
       
       // Calculer et afficher les moyennes des questions
       echo "<br><table style='margin: auto'>";
       echo "<tr> <td> Question </td> <td> Moyenne </td> </tr>";
  
       while($listeQuestions = pg_fetch_array($res_listeQuestions)){
           $libelleQuestion=$listeQuestions["libellequestion"];
           $idQuestion=$listeQuestions["idquestion"];
           echo "<tr> <td> ".$libelleQuestion."</td>";
          
           // Afficher la moyenne de la question
           echo "<td> ". moyenneQuestion($dateSession, $idQuestion)." % <td> </tr>";
       }
       echo "</table><br>";
       
    ?>
    </div>
</body>

</html>