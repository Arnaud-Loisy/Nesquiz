<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["IdQuestion"]))
{
	$idQuestion = $_POST["IdQuestion"];
	
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_supprimer_question_dans_matiere($idQuestion));
	}
}
?>