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

		echo "<table class = 'liste' id = 'table_libelles_questions_quiz'>";
		echo "<tbody>";
		echo "<th>Questions présentes</th>";

		while ($row = pg_fetch_array($result))
		{
			$libelleQuestion = $row["libellequestion"];
			$idQuestion = $row["idquestion"];
			/* echo "<tr><td onclick = 'SelectRow(".$i.", 2)' id = 'cell_".$i.",1'>$libelle</td></tr>"; */
			echo "<tr><td onclick = 'InvertColorOfTableLine(this)' id = '$idQuestion'>$libelleQuestion</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
?>