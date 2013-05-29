<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["IdQuestion"]) && isset($_POST["IdQuiz"]))
{
	$idQuestion = $_POST["IdQuestion"];
	$idQuiz = $_POST["IdQuiz"];
	
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_ajout_question_dans_quiz($idQuiz, $idQuestion));
	}
}
?>