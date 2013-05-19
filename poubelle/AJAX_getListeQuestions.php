<?php

include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';

/*
  header("Content-Type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
  echo "<list>";

  //$idEditor = (isset($_POST["IdEditor"])) ? htmlentities($_POST["IdEditor"]) : NULL;
  $idMatiere = (isset($_POST["IdMatiere"])) ? htmlentities($_POST["IdMatiere"]) : NULL;
  //$idMatiere = $_POST["IdMatiere"];
  //$idMatiere = 1;

  if ($idMatiere)
  {
  $dbcon = connexionBDD();
  $result = pg_query($dbcon, requete_toutes_questions_dans_matiere(1));
  while ($row = pg_fetch_array($result))
  {
  $libelleQuestion = $row["libellequestion"];
  $idQuestion = $row["idquestion"];
  echo "<item id=\"".$idQuestion."\" name=\"".$libelleQuestion."\" />";
  }
  }

  echo "</list>"; */
/*
if (isset($_POST["IdMatiere"]))
{
	$idMatiere = $_POST["IdMatiere"];
	$dbcon = connexionBDD();
	if (!$dbcon)
	{
		echo "connection BDD failed<br>";
	}
	else
	{*/
$dbcon=connexionBDD();
		$result = pg_query($dbcon, requete_toutes_questions_dans_matiere(1));

		echo "<select id='select_questions_matiere'>";

		while ($row = pg_fetch_array($result))
		{
			$libelleQuestion = $row["libellequestion"];
			$idQuestion = $row["idquestion"];
			echo "<option id = '$idQuestion' name='$libelleQuestion'>$libelleQuestion</option>";
		}
		echo "</select>";
	//}
//}
?>