<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["LibelleQuestion"]) && isset($_POST["TempsTotal"]) && isset($_POST["MotsCles"]) && isset($_POST["IdMatiere"]))
{
	$libelleQuestion = pg_escape_string($_POST["LibelleQuestion"]);
	$tempsQuestion = pg_escape_string($_POST["TempsTotal"]);
	$motsCles = pg_escape_string($_POST["MotsCles"]);
	$idMatiere = pg_escape_string($_POST["IdMatiere"]);
	
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_ajout_question_a_matiere($libelleQuestion, $tempsQuestion, $motsCles, $idMatiere));
	}
}
?>