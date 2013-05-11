<?php
    
    // Retourne la note d'un étudiant, pour une session, pour une question 
    function calculNoteQuestion($idEtu, $dateSession, $idQuestion){
       // récupérer le nb de réponses justes pour la question
               $request="SELECT COUNT(*)
                        FROM Reponses, Questions
                        WHERE Reponses.idQuestion = Questions.idQuestion
                        AND Reponses.valide=TRUE
                        AND Questions.idQuestion ='".$idQuestion."';";
                $res_nbRepJustes = pg_query($dbcon,$request) or die("Echec de la requête");
                $nbRepJustes = pg_fetch_array($res_nbRepJustes);
      
        // récupérer le nb de réponses fausses répondues par l'élève pour la question
                $request="  SELECT COUNT(*)
                            FROM Repond, Questions, Reponses, Sessions, Etudiants
                            WHERE Repond.idReponse = Reponses.idReponse
                            AND Repond.idQuestion = Questions.idQuestion
                            AND Repond.dateSession = Sessions.dateSession
                            AND Repond.idEtudiant = Etudiants.idEtudiant	
                            AND Etudiants.idEtudiant = '".$idEtu."'
                            AND Sessions.dateSession = '".$dateSession."'
                            AND Questions.idQuestion = '".$idQuestion."'
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
                            AND Etudiants.idEtudiant = '".$idEtu."'
                            AND Sessions.dateSession = '".$dateSession."'
                            AND Questions.idQuestion = '".$idQuestion."';";
                 $res_nbRepTotalEtu = pg_query($dbcon,$request) or die("Echec de la requête");
                 $nbRepTotalEtu = pg_fetch_array($res_nbRepTotalEtu);
                 
                  // Calculer la note de l'étudiant pour la question
                 if($nbRepFauxEtu[0]!=0)
                     $noteQuestion = 0;
                 else
                     $noteQuestion = $nbRepTotalEtu[0]/$nbRepJustes[0];
                 
                 return $noteQuestion;
    }
    
    // Retourne la note générale d'un étudiant, pour une session donnée
    // cette note est un rapport compris entre 0 et 1
    function calculNoteQuiz($idEtu, $dateSession){
            // récupérer id du quiz correspondant à la session
            $request= "SELECT idquiz
                        FROM Sessions
                        WHERE dateSession='".$dateSession."';";
            $res_idquiz = pg_query($dbcon,$request) or die("Echec de la requête");
            $tab_idquiz = pg_fetch_array($res_idquiz);
            $idquiz=$tab_idquiz[0];
        
            // récupérer nb questions du quiz
             $request="SELECT COUNT(*)
                        FROM Questions, Inclu, Quiz
                        WHERE	Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz = Inclu.idQuiz
                        AND Quiz.idQuiz ='".$idquiz."';"; 
             $res_nbQuestions = pg_query($dbcon,$request) or die("Echec de la requête");
             $nbQuestions = pg_fetch_array($res_nbQuestions);

             // récupérer la liste des questions du quiz
             $request="SELECT Questions.libelleQuestion, Questions.idQuestion
                        FROM Quiz, Questions, Inclu
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz ='".$idquiz."';";
             $res_listeQuestions = pg_query($dbcon,$request) or die("Echec de la requête");
             
             // Cumul des notes de chaque question
             $scoreTotal=0;
             while($listeQuestions = pg_fetch_array($res_listeQuestions)){
                   $scoreTotal+=calculNoteQuestion($idEtu, $dateSession, $listeQuestions["idquestion"]);
              }
              
           // Calcul de la note moyenne du quiz de l'étudiant
           $noteQuiz=$scoreTotal/$nbQuestions[0];
           
           return $noteQuiz;
    }
?>
