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

		echo "<table style='width: 400px;' class = 'TestScrollable' id = 'table_libelles_quiz'>";
		echo "<thead><th class='thFixed'>Nom du quiz</th><th class='thAuto'>Temps total</th></thead>";
		echo "<tbody>";

		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellequiz"];
			$idQuiz = $row["idquiz"];
			$tempsquiz = $row["tempsquiz"];
			echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td class='tdFixed'>$libelle</td>";
			echo "<td class='tdAuto'>$tempsquiz</td></tr>";
		}
		
		$result = pg_query($dbcon, requete_tous_quiz_sans_matiere($idMatiere));
		
		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellequiz"];
			$idQuiz = $row["idquiz"];
			$tempsquiz = $row["tempsquiz"];
			echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td class='tdFixed'><b><i>$libelle</i></b></td>";
			echo "<td class='tdAuto'>$tempsquiz</td></tr>";
		}
		
		echo "</tbody>";
		echo "</table>";
	}
}
?>