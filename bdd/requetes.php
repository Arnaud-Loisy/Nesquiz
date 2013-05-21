<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function requete_tous_quiz_dans_matiere($idMatiere)
{
	$requete = "SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
					FROM Quiz, Inclu, Questions, Matieres
					WHERE Quiz.idQuiz = Inclu.idQuiz
					AND Questions.idQuestion = Inclu.idQuestion
					AND Questions.idMatiere = Matieres.idMatiere
					AND Matieres.idMatiere = " . $idMatiere . ";";

	return $requete;
}

function requete_toutes_questions_dans_matiere($idMatiere)
{
	$requete = "SELECT libellequestion, tempsquestion, idquestion
					FROM questions, matieres
					WHERE questions.idmatiere = matieres.idmatiere
					AND matieres.idmatiere = " . $idMatiere . ";";

	return $requete;
}

function requete_toutes_questions_dans_quiz($idQuiz)
{
	$requete = "SELECT libelleQuestion, Questions.idQuestion
                    FROM Questions, Inclu, Quiz
                    WHERE Quiz.idQuiz = Inclu.idQuiz
                    AND Questions.idQuestion = Inclu.idQuestion
                    AND Quiz.idQuiz = " . $idQuiz . ";";

	return $requete;
}

function requete_toutes_matieres_pour_un_professeur($idAdminProf)
{
	$requete = "SELECT *
					FROM Matieres, AdminProfs, Enseigne
					WHERE AdminProfs.idAdminProf = Enseigne.idAdminProf
					AND Matieres.idMatiere = Enseigne.idMatiere
					AND AdminProfs.idAdminProf = " . $idAdminProf . ";";

	return $requete;
}

function requete_questions_d_une_session ($session)
{
	$requete = "SELECT questions.idquestion, questions.libellequestion, questions.tempsquestion 
				FROM   quiz, questions, inclu, sessions
				WHERE 	  quiz.idquiz = inclu.idquiz 
				AND	  inclu.idquestion = questions.idquestion 
				AND	  sessions.idquiz = inclu.idquiz 
				AND	  sessions.datesession = ".$session.";";
	return $requete;
}

function requete_reponses_d_une_question_d_une_session ($session,$idQuestion)
{
	$requete = "SELECT reponses.idreponse, reponses.libellereponse 
				FROM   quiz, questions, inclu, reponses, sessions
				WHERE 	  quiz.idquiz = inclu.idquiz 
				AND	  inclu.idquestion = questions.idquestion 
				AND	  reponses.idquestion = questions.idquestion 
				AND	  sessions.idquiz = inclu.idquiz 
				AND	  sessions.datesession = ".$session."
				AND	  reponses.idquestion =".$idQuestion.";";
	return $requete;
}

function requete_nb_de_questions_d_une_session ($session)
{
	$requete = "SELECT COUNT(*)
				FROM Questions, Inclu, Quiz, Sessions
				WHERE	Questions.idQuestion = Inclu.idQuestion
				AND Quiz.idQuiz = Inclu.idQuiz
				AND	sessions.idquiz = inclu.idquiz 
				AND	  sessions.datesession = $session;";
	return $requete;
}

function requete_insertion_des_reponses_choisies ($SQLQuestion,$SQLreponse,$id,$dateSession)
{
	$requete = "INSERT INTO repond
				VALUES (" . $SQLQuestion . ",
						" . $SQLreponse . ",
						" . $id . ",
						" . $dateSession . ");";
	return $requete;
}

function requete_efface_les_reponses_d_une_question_d_une_session_d_un_etudiant ($SQLQuestion,$id,$dateSession)
{
	$requete = "DELETE FROM repond
 				WHERE idquestion = ".$SQLQuestion."
				AND idetudiant = ".$id."
				AND datesession = ".$dateSession.";";
	return $requete;
}

function requete_temps_session ($dateSession)
{
	$requete = "SELECT tempsquiz
				FROM   quiz, sessions
				WHERE  quiz.idquiz = sessions.idquiz
				AND datesession = ".$dateSession.";";
	return $requete;
}

function requete_mdp_etat_session($dateSession)
{
	$requete = "SELECT mdpsession,etatsession
				FROM Sessions
				WHERE datesession =".$dateSession.";";
	return $requete;
}

function requete_participer_a_une_session($id,$dateSession)
{
	$requete = "INSERT INTO PARTICIPE values (".$id.",".$dateSession."); ";
	return $requete;
}

function requete_liste_session_ouvertes()
{
	$requete = "SELECT libelleQuiz,datesession
				FROM Sessions, Quiz	
				WHERE Sessions.idQuiz = Quiz.idQuiz	
				AND Sessions.etatsession=1
				ORDER BY datesession DESC;";
	return $requete;
}


function requete_libelleQuiz($idQuiz){
     $request = "SELECT libelleQuiz 
                        FROM quiz
                        WHERE idquiz  = '".$idQuiz."';";
     return $request;
}

function requete_etudiants_participants($dateSession){
    $request="SELECT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant
                                    FROM Etudiants, Sessions, Participe
                                    WHERE Sessions.dateSession = Participe.dateSession
                                    AND Participe.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession='".$dateSession."';";
    return $request;

}

function requete_nb_questions_repondues_par_un_etudiant($dateSession, $idEtu){
      $request = "SELECT COUNT (DISTINCT(Questions.idQuestion))
                 FROM Repond, Etudiants, Sessions, Questions, Reponses
                 WHERE Repond.idEtudiant = Etudiants.idEtudiant
                 AND Repond.idQuestion = Questions.idQuestion
                 AND Repond.dateSession = Sessions.dateSession
                 AND Repond.idReponse = Reponses.idReponse
                 AND Sessions.dateSession='".$dateSession."'
                  AND Etudiants.idEtudiant='".$idEtu."';";
    return $request;
}

function requete_matieres_d_un_prof($idProf){
    $request = "SELECT * FROM Matieres, AdminProfs, Enseigne 
                    WHERE AdminProfs.idAdminProf = Enseigne.idAdminProf 
                    AND Matieres.idMatiere = Enseigne.idMatiere 
                    AND AdminProfs.idAdminProf = ".$idProf.";";
    return $request;
}

function requete_liste_quiz_d_une_matiere($idMatiere){
     $request="  SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
                        FROM Quiz, Inclu, Questions, Matieres
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Questions.idMatiere = Matieres.idMatiere
                        AND Matieres.idMatiere =".$idMatiere.";";

     return $request;
}

function requete_changer_etat_session($dateSession,$etatSession){
     $request="UPDATE Sessions
              SET etatSession='".$etatSession."'
              WHERE dateSession='".$dateSession."';";
     return $request;
}

function requete_idQuiz_correspondant_session($dateSession){
    $request= "SELECT idquiz
               FROM Sessions
               WHERE dateSession='".$dateSession."';";

    return $request;
}

function requete_creer_session($dateSession,$modeFonctionnement, $mdpSession, $idquiz, $etatsession){
    $request = "INSERT INTO sessions VALUES 
    ('".$dateSession."','".$modeFonctionnement."','".$mdpSession."','".$idquiz."','".$etatsession."');";

    return $request;
}

function requete_nb_rep_justes_question($idQuestion){
    $request="SELECT COUNT(*)
                        FROM Reponses, Questions
                        WHERE Reponses.idQuestion = Questions.idQuestion
                        AND Reponses.valide=TRUE
                        AND Questions.idQuestion ='".$idQuestion."';";
    return $request;
}

function requete_nb_rep_fausses_d_un_etudiant_pour_question_d_une_session($idEtu,$idQuestion,$dateSession ){
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

    return $request;
}

function requete_nb_rep_totales_d_un_etudiant_pour_question_d_une_session($idEtu,$idQuestion,$dateSession ){
    $request="  SELECT COUNT(*)
                            FROM Repond, Questions, Reponses, Sessions, Etudiants
                            WHERE Repond.idReponse = Reponses.idReponse
                            AND Repond.idQuestion = Questions.idQuestion
                            AND Repond.dateSession = Sessions.dateSession
                            AND Repond.idEtudiant = Etudiants.idEtudiant	
                            AND Etudiants.idEtudiant = '".$idEtu."'
                            AND Sessions.dateSession = '".$dateSession."'
                            AND Questions.idQuestion = '".$idQuestion."';"; 

    return $request;
}

function requete_nb_questions_d_un_quiz($idQuiz){
    $request="SELECT COUNT(*)
                        FROM Questions, Inclu, Quiz
                        WHERE	Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz = Inclu.idQuiz
                        AND Quiz.idQuiz ='".$idQuiz."';"; 

    return $request;
}

function requete_liste_questions_d_un_quiz($idquiz){
     $request="SELECT Questions.libelleQuestion, Questions.idQuestion
                        FROM Quiz, Questions, Inclu
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz ='".$idquiz."';";

     return $request;
}

function requete_liste_sessions_terminees(){
     $request = "SELECT dateSession, libelleQuiz
                    FROM Sessions, Quiz
                    WHERE Sessions.idQuiz = Quiz.idQuiz
                    AND Sessions.etatSession = 3
                    ORDER BY Sessions.dateSession DESC;";

     return $request;
}

function requete_supprimer_session($dateSession){
    $request = "DELETE FROM Repond
                        WHERE dateSession='".$dateSession."';
                        DELETE FROM Participe
                        WHERE dateSession='".$dateSession."';
                        DELETE FROM Sessions
                        WHERE dateSession='".$dateSession."';";
    return $request;
}

function requete_tous_idadminprof_nomadminprof_prenomadminprof ()
{
    $requete = "SELECT idadminprof,nomadminprof,prenomadminprof
                FROM adminprofs
                ORDER BY nomadminprof";
    return $requete;
}

function requete_tous_idadminprof($idadminprof)
{
    $requete = "SELECT idAdminProf 
                 FROM AdminProfs 
                 WHERE idAdminProf =".$idadminprof;
    return $requete;
}

function requete_inserer_prof($identifiant,$nom, $prenom,$mdph,$adminb,$langue)
{
    $requete = "INSERT INTO AdminProfs 
                VALUES (".$identifiant.", '".$nom."', '".$prenom."','".$mdph."','".$adminb."','".$langue."');";
    return $requete;
}

function requete_supprimer_prof($idadminprof)
{
    $requete = "DELETE
                FROM adminprofs
                WHERE idadminprof ='".$idadminprof."'";
    return $requete;
}

function requete_toutes_matieres_d_un_etudiant($idEtu)
{
	$requete = "SELECT DISTINCT(matieres.libellematiere),matieres.idmatiere
				FROM etudiants,	matieres, sessions, participe, questions, inclu
				WHERE matieres.idmatiere = questions.idmatiere 
				AND  sessions.datesession = participe.datesession
				AND  participe.idetudiant = etudiants.idetudiant 
				AND  inclu.idquiz = sessions.idquiz 
				AND  inclu.idquestion = questions.idquestion 
				AND  etudiants.idetudiant=".$idEtu."
				ORDER BY matieres.libellematiere ASC;";
	return $requete;
}
function requete_nombre_de_sessions_d_un_etudiant($idEtu)
{
	$requete = "SELECT count (*) 
				FROM participe
				WHERE idetudiant =$idEtu;";
	return $requete;
}

function requete_nombre_de_sessions_d_un_etudiant_matiere_donnee($idEtu,$idMatiere)
{
	$requete = "SELECT COUNT(DISTINCT (participe.datesession))
				FROM   public.participe,   public.inclu,   public.sessions,   public.questions
				WHERE   participe.datesession = sessions.datesession 
				AND  inclu.idquestion = questions.idquestion 
				AND  inclu.idquiz = sessions.idquiz
				AND  idetudiant=".$idEtu." 
				AND   idmatiere =".$idMatiere.";";
	return $requete;
}

function requete_sessions_d_un_etudiant($idEtu)
{
	$requete = "SELECT dateSession 
				FROM participe
				WHERE idetudiant =$idEtu;";
	return $requete;
}

function requete_sessions_d_un_etudiant_par_matiere($idEtu,$idMatiere)
{
	$requete = "SELECT DISTINCT(participe.datesession)
				FROM  participe, inclu, sessions, questions
				WHERE participe.datesession = sessions.datesession 
				AND  inclu.idquestion = questions.idquestion 
				AND  inclu.idquiz = sessions.idquiz 
				AND  idetudiant=".$idEtu." 
				AND   idmatiere =".$idMatiere.";";
	return $requete;
}

?>
