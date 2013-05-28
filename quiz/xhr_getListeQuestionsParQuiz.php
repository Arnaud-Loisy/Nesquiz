<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

if (isset($_POST["IdQuiz"]))
{
	$idQuiz = $_POST["IdQuiz"];
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{
		$result = pg_query($dbcon, requete_toutes_questions_dans_quiz($idQuiz));

		echo "<table class ='TestScrollable' style='width: 400px;' id = 'table_libelles_questions_quiz'>";
		echo "<thead><th style='width:  400px'>Questions présentes</th></thead>";
		echo "<tbody>";

		while ($row = pg_fetch_array($result))
		{
			$libelleQuestion = $row["libellequestion"];
			$idQuestion = $row["idquestion"];
			echo "<tr onclick = 'InvertColorOfTableLine(this)' id = '$idQuestion'><td style ='width: 400px'>$libelleQuestion</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
?>