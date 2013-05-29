<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["IdQuestion"]) && isset($_POST["IdReponse"]))
{
	$idQuestion = $_POST["IdQuestion"];
	$idReponse = $_POST["IdReponse"];
	
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_supprimer_reponse_dans_question($idReponse, $idQuestion));
	}
}
?>