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
			include '../session/fonctions_resultats.php';

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
				$result = pg_query($dbcon, requete_toutes_matieres_d_un_etudiant($idEtu));

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
				
				$result = pg_query($dbcon, requete_nombre_de_sessions_d_un_etudiant($idEtu));
				$row = pg_fetch_array($result);
				$totalSession = $row["count"];
				
				
				
				
				
				
				echo "<br><br><br><br><table style='margin: 0; text-align:right;'>
						<tr>
							<td> Matière </td>
							<td> Ma Moyenne </td>
							<td> Nombre de sessions </td>
							<td> Moyenne de la promotion </td>
							<td> Classement </td>
						</tr>
						<tr>
							<td> Toutes </td>
							<td> ".moyenneGenerale($idEtu)."% </td>
							<td>".$totalSession."</td>
							<td> XX.YY% </td>
							<td> XX/YY </td>
						</tr>";
						
				$result = pg_query($dbcon, requete_toutes_matieres_d_un_etudiant($idEtu));
				while ($row = pg_fetch_array($result))
				{
					$libelleMatiere = $row["libellematiere"];
					$idMatiere = $row["idmatiere"];
					$result_nbSession = pg_query($dbcon,requete_nombre_de_sessions_d_un_etudiant_matiere_donnee($idEtu,$idMatiere));
					$nbSession = pg_fetch_array($result_nbSession);
					
					
					echo "<tr>
							<td>".$libelleMatiere."</td>
							<td> ".moyenneMatiere($idEtu,$idMatiere)."% </td>
							<td>".$nbSession['count']."</td>
							<td> XX.XX% </td>
							<td> XX/XX </td>
						</tr>";
				}
						
						echo "</table>";
			}
			
			?>
		</div>
	</body>
</html>