<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function requete_tous_quiz_dans_matiere($idMatiere)
{
	$requete = "SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz, Quiz.tempsQuiz
					FROM Quiz, Inclu, Questions, Matieres
					WHERE Quiz.idQuiz = Inclu.idQuiz
					AND Questions.idQuestion = Inclu.idQuestion
					AND Questions.idMatiere = Matieres.idMatiere
					AND Matieres.idMatiere = ".$idMatiere.";";

	return $requete;
}

function requete_tous_quiz_sans_matiere()
{
	$requete = "SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz, Quiz.tempsQuiz
				FROM Quiz
				WHERE Quiz.idQuiz
				NOT IN (
					SELECT DISTINCT Quiz.idQuiz
					FROM Quiz, Inclu, Matieres	
					WHERE Quiz.idQuiz = Inclu.idQuiz);";

	return $requete;
}

function requete_toutes_questions_dans_matiere($idMatiere)
{
	$requete = "SELECT libellequestion, tempsquestion, idquestion, motscles
					FROM questions, matieres
					WHERE questions.idmatiere = matieres.idmatiere
					AND matieres.idmatiere = ".$idMatiere.";";

	return $requete;
}

function requete_toutes_questions_dans_quiz($idQuiz)
{
	$requete = "SELECT libelleQuestion, Questions.idQuestion
                    FROM Questions, Inclu, Quiz
                    WHERE Quiz.idQuiz = Inclu.idQuiz
                    AND Questions.idQuestion = Inclu.idQuestion
                    AND Quiz.idQuiz = ".$idQuiz.";";

	return $requete;
}

function requete_toutes_matieres_pour_un_professeur($idAdminProf)
{
	$requete = "SELECT *
					FROM Matieres, AdminProfs, Enseigne
					WHERE AdminProfs.idAdminProf = Enseigne.idAdminProf
					AND Matieres.idMatiere = Enseigne.idMatiere
					AND AdminProfs.idAdminProf = '".$idAdminProf."';";

	return $requete;
}

function requete_questions_d_une_session($session)
{
	$requete = "SELECT questions.idquestion, questions.libellequestion, questions.tempsquestion 
				FROM   quiz, questions, inclu, sessions
				WHERE 	  quiz.idquiz = inclu.idquiz 
				AND	  inclu.idquestion = questions.idquestion 
				AND	  sessions.idquiz = inclu.idquiz 
				AND	  sessions.datesession = ".$session.";";
	return $requete;
}

function requete_reponses_d_une_question_d_une_session($session, $idQuestion)
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

function requete_nb_de_questions_d_une_session($session)
{
	$requete = "SELECT COUNT(*)
				FROM Questions, Inclu, Quiz, Sessions
				WHERE	Questions.idQuestion = Inclu.idQuestion
				AND Quiz.idQuiz = Inclu.idQuiz
				AND	sessions.idquiz = inclu.idquiz 
				AND	  sessions.datesession = $session;";
	return $requete;
}

function requete_insertion_des_reponses_choisies($SQLQuestion, $SQLreponse, $id, $dateSession)
{
	$requete = "INSERT INTO repond
				VALUES (".$SQLQuestion.",
						".$SQLreponse.",
						".$id.",
						".$dateSession.");";
	return $requete;
}

function requete_efface_les_reponses_d_une_question_d_une_session_d_un_etudiant($SQLQuestion, $id, $dateSession)
{
	$requete = "DELETE FROM repond
 				WHERE idquestion = ".$SQLQuestion."
				AND idetudiant = ".$id."
				AND datesession = ".$dateSession.";";
	return $requete;
}

function requete_temps_session($dateSession)
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

function requete_participer_a_une_session($id, $dateSession)
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

function requete_libelleQuiz($idQuiz)
{
	$request = "SELECT libelleQuiz 
                        FROM quiz
                        WHERE idquiz  = '".$idQuiz."';";
	return $request;
}

function requete_etudiants_participants($dateSession)
{
	$request = "SELECT Etudiants.nomEtudiant, Etudiants.prenomEtudiant, Etudiants.idEtudiant
                                    FROM Etudiants, Sessions, Participe
                                    WHERE Sessions.dateSession = Participe.dateSession
                                    AND Participe.idEtudiant = Etudiants.idEtudiant
                                    AND Sessions.dateSession='".$dateSession."';";
	return $request;
}

function requete_nb_etudiants_participants($dateSession)
{
	$request = "SELECT COUNT (idEtudiant)
				FROM Participe
                WHERE dateSession='".$dateSession."';";
	return $request;
}

function requete_nb_etudiants_participants_par_matiere($promo, $idMatiere)
{
	$request = "SELECT COUNT (DISTINCT (participe.idetudiant))
				FROM inclu, sessions, participe, questions, etudiants
				WHERE  sessions.idquiz = inclu.idquiz 
				AND participe.datesession = sessions.datesession 
				AND etudiants.idetudiant = participe.idetudiant
				AND etudiants.promo = ".$promo." 
				AND questions.idmatiere = ".$idMatiere." 
				AND questions.idquestion = inclu.idquestion;";
	return $request;
}

function requete_etudiants_participants_par_matiere($promo, $idMatiere)
{
	$request = "SELECT DISTINCT (participe.idetudiant)
				FROM inclu, sessions, participe, questions, etudiants
				WHERE  sessions.idquiz = inclu.idquiz 
				AND participe.datesession = sessions.datesession 
				AND etudiants.idetudiant = participe.idetudiant
				AND etudiants.promo = ".$promo." 
				AND questions.idmatiere = ".$idMatiere." 
				AND questions.idquestion = inclu.idquestion;";
	return $request;
}

function requete_nb_questions_repondues_par_un_etudiant($dateSession, $idEtu)
{
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

function requete_liste_quiz_d_une_matiere($idMatiere)
{
	$request = "  SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
                        FROM Quiz, Inclu, Questions, Matieres
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Questions.idMatiere = Matieres.idMatiere
                        AND Matieres.idMatiere =".$idMatiere.";";

	return $request;
}

function requete_changer_etat_session($dateSession, $etatSession)
{
	$request = "UPDATE Sessions
              SET etatSession='".$etatSession."'
              WHERE dateSession='".$dateSession."';";
	return $request;
}

function requete_idQuiz_correspondant_session($dateSession)
{
	$request = "SELECT idquiz
               FROM Sessions
               WHERE dateSession='".$dateSession."';";

	return $request;
}

function requete_creer_session($dateSession, $modeFonctionnement, $mdpSession, $idquiz, $etatsession)
{
	$request = "INSERT INTO sessions VALUES 
    ('".$dateSession."','".$modeFonctionnement."','".$mdpSession."','".$idquiz."','".$etatsession."');";

	return $request;
}

function requete_nb_rep_justes_question($idQuestion)
{
	$request = "SELECT COUNT(*)
                        FROM Reponses, Questions
                        WHERE Reponses.idQuestion = Questions.idQuestion
                        AND Reponses.valide=TRUE
                        AND Questions.idQuestion ='".$idQuestion."';";
	return $request;
}

function requete_nb_rep_fausses_d_un_etudiant_pour_question_d_une_session($idEtu, $idQuestion, $dateSession)
{
	$request = "  SELECT COUNT(*)
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

function requete_nb_rep_totales_d_un_etudiant_pour_question_d_une_session($idEtu, $idQuestion, $dateSession)
{
	$request = "  SELECT COUNT(*)
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

function requete_nb_questions_d_un_quiz($idQuiz)
{
	$request = "SELECT COUNT(*)
                        FROM Questions, Inclu, Quiz
                        WHERE	Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz = Inclu.idQuiz
                        AND Quiz.idQuiz ='".$idQuiz."';";

	return $request;
}

function requete_liste_questions_d_un_quiz($idquiz)
{
	$request = "SELECT Questions.libelleQuestion, Questions.idQuestion
                        FROM Quiz, Questions, Inclu
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Quiz.idQuiz ='".$idquiz."';";

	return $request;
}

function requete_liste_sessions_terminees()
{
	$request = "SELECT dateSession, libelleQuiz
                    FROM Sessions, Quiz
                    WHERE Sessions.idQuiz = Quiz.idQuiz
                    AND Sessions.etatSession = 3
                    ORDER BY Sessions.dateSession DESC;";

	return $request;
}

function requete_supprimer_session($dateSession)
{
	$request = "DELETE FROM Repond
                        WHERE dateSession='".$dateSession."';
                        DELETE FROM Participe
                        WHERE dateSession='".$dateSession."';
                        DELETE FROM Sessions
                        WHERE dateSession='".$dateSession."';";
	return $request;
}

function requete_tous_idadminprof_nomadminprof_prenomadminprof()
{
	$requete = "SELECT idadminprof,nomadminprof,prenomadminprof
                FROM adminprofs
                ORDER BY nomadminprof";

	return $requete;
}

function requete_idadminprof_d_une_matiere($idMatiere)
{
	$requete = "SELECT DISTINCT(adminprofs.idadminprof), adminprofs.nomadminprof, adminprofs.prenomadminprof
				FROM adminprofs, enseigne, matieres
				WHERE enseigne.idadminprof = adminprofs.idadminprof 
				AND  enseigne.idmatiere = matieres.idmatiere
  				AND enseigne.idmatiere=".$idMatiere.";";
  				

	return $requete;
}

function requete_tous_idadminprof($idadminprof)
{
	$requete = "SELECT idAdminProf 
                 FROM AdminProfs 
                 WHERE idAdminProf ='".$idadminprof."';";
	return $requete;
}

function requete_inserer_prof($identifiant, $nom, $prenom, $mdph, $adminb, $langue)
{
	$requete = "INSERT INTO AdminProfs 
                VALUES ('".$identifiant."', '".$nom."', '".$prenom."','".$mdph."','".$adminb."','".$langue."');";
	return $requete;
}

function requete_supprimer_prof($idadminprof)
{
	$requete = "DELETE
                FROM adminprofs
                WHERE idadminprof ='".$idadminprof."';";
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
				WHERE idetudiant =".$idEtu.";";
	return $requete;
}

function requete_nombre_de_sessions_d_un_etudiant_matiere_donnee($idEtu, $idMatiere)
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
				WHERE idetudiant =".$idEtu.";";
	return $requete;
}

function requete_sessions_d_un_etudiant_par_matiere($idEtu, $idMatiere)
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

function requete_etudiant_d_une_promo($promo)
{
	$requete = "SELECT DISTINCT(etudiants.idetudiant)
				FROM  participe, sessions, quiz, etudiants
				WHERE  participe.datesession = sessions.datesession 
				AND  sessions.idquiz = quiz.idquiz 
				AND  etudiants.idetudiant = participe.idetudiant
 				AND etudiants.promo=".$promo.";";
	return $requete;
}

function requete_nb_etudiant_d_une_promo($promo)
{
	$requete = "SELECT COUNT(DISTINCT(etudiants.idetudiant))
				FROM  participe, sessions, quiz, etudiants
				WHERE  participe.datesession = sessions.datesession 
				AND  sessions.idquiz = quiz.idquiz 
				AND  etudiants.idetudiant = participe.idetudiant
 				AND etudiants.promo=".$promo.";";
	return $requete;
}

function requete_prof_devient_admin($idadminprof)
{
	$requete = "UPDATE AdminProfs
                SET admin = 'true'
                WHERE idadminprof = '".$idadminprof."';";
	return $requete;
}

function requete_promo_d_un_etudiant($idEtu)
{
	$requete = "SELECT promo
				FROM etudiants
				WHERE idetudiant=".$idEtu.";";
	return $requete;
}

function requete_liste_quiz_entier_d_une_matiere($idMatiere)
{
	$request = "  SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
                        FROM Quiz, Inclu, Questions, Matieres
                        WHERE Quiz.idQuiz = Inclu.idQuiz
                        AND Questions.idQuestion = Inclu.idQuestion
                        AND Questions.idMatiere = Matieres.idMatiere
                        AND Matieres.idMatiere =".$idMatiere."
                        AND Quiz.tempsQuiz != 0;";
	return $request;
}

function requete_si_admin($idadminprof)
{
	$requete = "SELECT admin
              FROM adminprofs
              WHERE idadminprof ='".$idadminprof."';";
	return $requete;
}

function requete_creer_quiz($nomQuiz, $tempsQuiz)
{
	$request = "INSERT INTO QUIZ (libellequiz,tempsquiz) VALUES ('".$nomQuiz."','".$tempsQuiz."');";

	return $request;
}

function requete_admin_devient_prof($idadminprof)
{
	$requete = "UPDATE Adminprofs
              SET admin='false'
              WHERE idadminprof='".$idadminprof."';";
	return $requete;
}

function requete_promotion_des_etudiants()
{
	$requete = "SELECT DISTINCT (promo)
				FROM etudiants
				ORDER BY promo DESC;";
	return $requete;
}

function requete_nom_prenom_etudiant($idEtu)
{
	$request = "SELECT nomEtudiant, prenomEtudiant
               FROM Etudiants
               WHERE idEtudiant = ".$idEtu.";";

	return $request;
}

function requete_ajout_question_dans_quiz($idQuiz, $idQuestion)
{
	$requete = "INSERT INTO Inclu
				VALUES('".$idQuiz."', '".$idQuestion."');";

	return $requete;
}

function requete_matieres()
{
	$requete = "SELECT * 
				FROM matieres
				ORDER BY libellematiere ASC;";

	return $requete;
}

function requete_tous_les_etudiants()
{
	$requete = "SELECT idetudiant,nometudiant,prenometudiant,promo
                FROM etudiants";
	return $requete;
}

function requete_insertion_matiere($libelleMatiere)
{
	$requete = "INSERT INTO matieres (libellematiere) VALUES('".$libelleMatiere."');";

	return $requete;
}

function requete_effacement_matiere($idMatiere)
{
	$request = "DELETE FROM Matieres
                        WHERE idMatiere='".$idMatiere."';
                        DELETE FROM Enseigne
                        WHERE idMatiere='".$idMatiere."';";

	return $request;
}

function requete_supprimer_question_dans_quiz($idQuiz, $idQuestion)
{
	$requete = "DELETE FROM Inclu
					WHERE idQuiz='".$idQuiz."'
					AND idQuestion='".$idQuestion."';";

	return $requete;
}
function requete_dissocier_prof_a_matiere($idAdminProf, $idMatiere)
{
	$requete = "DELETE FROM Enseigne
					WHERE idAdminProf='".$idAdminProf."'
					AND idMatiere='".$idMatiere."';";
	
	return $requete;
}
function requete_associer_prof_a_matiere($idAdminProf, $idMatiere)
{
	$requete = "INSERT INTO Enseigne
				VALUES('".$idMatiere."', '".$idAdminProf."');";
	
	return $requete;
}

function requete_toutes_reponses_dans_question($idQuestion) {
	$requete = "SELECT libelleReponse, valide
					FROM Reponses, Questions
					WHERE Reponses.idQuestion = Questions.idQuestion
					AND Questions.idQuestion = '".$idQuestion."';";
	
	return $requete;
}
?>
