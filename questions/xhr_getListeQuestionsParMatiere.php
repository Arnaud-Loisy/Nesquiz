<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["IdMatiere"]))
{
	$idMatiere = $_POST["IdMatiere"];
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_toutes_questions_dans_matiere($idMatiere));

		echo "<table style='width: 100%;' class = 'TestScrollable' id = 'table_libelles_questions'>";
		echo "<thead><th style='min-width: 600px; width: 600px'>Question</th><th class='thAuto' style='min-width: 150px; width: 150px'>Mots clés</th><th class='thAuto'>Temps total</th></thead>";
		echo "<tbody style='width: 100%'>";

		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellequestion"];
			$idQuestion = $row["idquestion"];
			$tempsquestion = $row["tempsquestion"];
			$motscles = $row["motscles"];
			echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuestionEnCours(this)' id = '$idQuestion'><td style='min-width: 600px; width: 600px'>$libelle</td>";
			echo "<td class='tdAuto' style='width: 150px; min-width: 150px; max-width: 150px'>$motscles</td>";
			echo "<td class='tdAuto'>$tempsquestion</td></tr>";
		}

		echo "</tbody>";
		echo "</table>";
	}
}
?>