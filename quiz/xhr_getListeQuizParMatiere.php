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
		$result = pg_query($dbcon, requete_tous_quiz_dans_matiere($idMatiere));

		echo "<table class = 'liste' id = 'table_libelles_quiz'>";
		echo "<tbody>";
		echo "<th>Nom du quiz</th>";

		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellequiz"];
			$idQuiz = $row["idquiz"];
			echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td>$libelle</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
?>