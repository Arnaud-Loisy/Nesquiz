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
					WHERE Quiz.idQuiz = Inclu.idQuiz
					AND Questions.idQuestion = Inclu.idQuestion
					AND Quiz.idQuiz = " . $idQuiz . ";";

	return $requete;
}

function requete_toutes_matieres_pour_un_professeur($idAdminProf)
{
	$requete = "SELECT *
					FROM Matières, AdminProf, Enseigne
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



?>
