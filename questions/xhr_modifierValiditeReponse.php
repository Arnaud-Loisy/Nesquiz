<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["Valide"]) && isset($_POST["IdReponse"]))
{
	$valide = pg_escape_string($_POST["Valide"]);
	$idReponse = pg_escape_string($_POST["IdReponse"]);
	
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_modifier_validite_reponse($valide, $idReponse));
	}
}
?>
