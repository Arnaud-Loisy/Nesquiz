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

		echo "<table class = 'liste listeScrollable' id = 'table_libelles_quiz'>";
		echo "<thead style='width: 100%;'><th style='width: 720px'>Nom du quiz</th><th style='width: 100px'>Temps total</th></thead>";
		echo "<tbody>";

		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellequiz"];
			$idQuiz = $row["idquiz"];
			$tempsquiz = $row["tempsquiz"];
			echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td style='width: 720px'>$libelle</td>";
			echo "<td style='width: 100px'>$tempsquiz</td></tr>";
		}
		
		$result = pg_query($dbcon, requete_tous_quiz_sans_matiere($idMatiere));
		
		while ($row = pg_fetch_array($result))
		{
			$libelle = $row["libellequiz"];
			$idQuiz = $row["idquiz"];
			$tempsquiz = $row["tempsquiz"];
			echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td><b><i>$libelle</i></b></td>";
			echo "<td>$tempsquiz</td></tr>";
		}
		
		echo "</tbody>";
		echo "</table>";
	}
}
?>