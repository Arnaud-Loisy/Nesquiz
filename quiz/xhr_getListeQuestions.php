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

		echo "<select id='select_questions_matiere'>";

		while ($row = pg_fetch_array($result))
		{
			$libelleQuestion = $row["libellequestion"];
			$idQuestion = $row["idquestion"];
			echo "<option id = '$idQuestion' name='$libelleQuestion'>$libelleQuestion</option>";
		}
		echo "</select>";
	}
}
?>