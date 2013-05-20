<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Notes</title>
		<link rel="stylesheet" href="../styles/theme.css" />

	</head>
	<body>
		<div id='page'>
			<?php
			session_start();
			date_default_timezone_set("Europe/Paris");
			include '../accueil/menu.php';
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';

			if ((!isset($_SESSION["id"])) || !($_SESSION["statut"]=="etu")) {
				header('Location:../index.php');
			}
			else {
				$idEtu = $_SESSION["id"];

			$dbcon = connexionBDD();

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$requete = "SELECT DISTINCT(matieres.libellematiere),matieres.idmatiere
				FROM etudiants,	matieres, sessions, participe, questions, inclu
				WHERE matieres.idmatiere = questions.idmatiere 
				AND  sessions.datesession = participe.datesession
				AND  participe.idetudiant = etudiants.idetudiant 
				AND  inclu.idquiz = sessions.idquiz 
				AND  inclu.idquestion = questions.idquestion 
				AND  etudiants.idetudiant=".$idEtu."
				ORDER BY matieres.libellematiere ASC;";
				$result = pg_query($dbcon, $requete);

				echo "<h1 >Mes Notes :</h1>";
				echo "<div style='display: inline-table;' class='radioButtons'>";
				echo "<span><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_Toutes' name='radios_matieres' value='x' checked='true'/>";
				echo "<label for='radio_Toutes'>Toutes</label></span>";

				while ($row = pg_fetch_array($result))
				{
					$libelleMatiere = $row["libellematiere"];
					$idMatiere = $row["idmatiere"];

					echo "<span class='rightRadioButton'><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_".$libelleMatiere."' name='radios_matieres' value='".$idMatiere."' />";
					echo "<label for='radio_".$libelleMatiere."'>".$libelleMatiere."</label></span>";
				}
				echo "</div>";
			}
				
				
				
				
				
				
				
				
				
				
				echo "<br><br><br><br><table style='margin: auto'>
						<tr>
							<td> Matière </td>
							<td> Ma Moyenne </td>
							<td> Nombre de sessions </td>
							<td> Moyenne de la promotion </td>
							<td> Classement </td>
						</tr>";
						
						echo "</table>";
			}
			
			?>
		</div>
	</body>
</html>