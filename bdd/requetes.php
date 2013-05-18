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

?>
