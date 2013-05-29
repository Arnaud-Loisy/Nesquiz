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
		$result = pg_query($dbcon, requete_toutes_reponses_dans_question($idQuestion));

		echo "<table class ='TestScrollable' style='width: 500px;' id = 'table_libelles_reponses_questions'>";
		echo "<thead><th style='min-width: 400px; width: 400px'>Réponse</th><th class='thAuto'>Correcte?</th></thead>";
		echo "<tbody style='width: 100%'>";

		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellereponse"];
			$idReponse = $row["idreponse"];
			$valide = $row["valide"];
			echo "<tr onclick = 'InvertColorOfTableLine(this)' id = '$idReponse'><td class='tdFixed' style='min-width: 400px; width: 400px'>$libelle</td>";
			if ($valide == 't')
				echo "<td class='tdAuto'><input onClick='ModifierValiditeReponse(this)' id='".$idReponse."' type='checkbox' name='validite' value='".$valide."' checked/></tr>";
			else
				echo "<td class='tdAuto'><input onClick='ModifierValiditeReponse(this)' id='".$idReponse."' type='checkbox' name='validite' value='".$valide."'/></tr>";
		}
		
		echo "</tbody>";
		echo "</table>";
	}
}
?>