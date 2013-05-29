<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["LibelleReponse"]) && isset($_POST["Valide"]) && isset($_POST["IdQuestion"]))
{
	$libelleReponse = pg_escape_string($_POST["LibelleReponse"]);
	$valide = pg_escape_string($_POST["Valide"]);
	$idQuestion = pg_escape_string($_POST["IdQuestion"]);
	
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_ajout_reponse_a_question($libelleReponse, $valide, $idQuestion));
	}
}
?>
