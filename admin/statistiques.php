<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Notes</title>
		<link rel="stylesheet" href="../styles/theme.css" />
		<script type='text/javascript'>
			function changerStats(radiobtn) {
				var idMatiere = radiobtn.value;
				
				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_stats.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200) {
						//alert(xhr.responseText);
						document.getElementById('table_stat').innerHTML = xhr.responseText;
					}
				};

				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("idMatiere=" + idMatiere);
				

			}
			
			function filtrer(select) {
				var promo = select.id;
				
				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_stats.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200) {
						//alert(xhr.responseText);
						document.getElementById('table_stat').innerHTML = xhr.responseText;
					}
				};

				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("promo=" + promo);
				

			}

		</script>
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

			if ((!isset($_SESSION["id"])) || ($_SESSION["statut"] == "etu")) {
				header('Location:../index.php');
			} else {
				$idAdminProf = $_SESSION["id"];

				$dbcon = connexionBDD();

				if (!$dbcon) {
					echo "connection BDD failed<br>";
				} else {
					$result = pg_query($dbcon, requete_toutes_matieres_pour_un_professeur($idAdminProf));
					$row = pg_fetch_array($result);
					$libelleMatiere = $row["libellematiere"];
					$idMatiere = $row["idmatiere"];
					echo "<h1>Mes Matières : </h1>";
					echo "<div style='margin: auto;' class='radioButtons'>";
					echo "<span><input onClick = 'changerStats(this)' type ='radio' id='" . $libelleMatiere . "' name='radios_matieres' value='" . $idMatiere . "' checked='true'/>";
					echo "<label for='" . $libelleMatiere . "'>" . $libelleMatiere . "</label></span>";
					

					while ($row = pg_fetch_array($result)) {
						$libelleMatiere = $row["libellematiere"];
						$idBtMatiere = $row["idmatiere"];

						echo "<span class='rightRadioButton'><input onClick = 'changerStats(this)' type ='radio' id='" . $libelleMatiere . "' name='radios_matieres' value='" . $idBtMatiere . "'/>";
						echo "<label for='" . $libelleMatiere . "'>" . $libelleMatiere . "</label></span>";
					}
					echo "</div>";
					
					$result = pg_query($dbcon,requete_promotion_des_etudiants());
					$row = pg_fetch_array($result);
					$promo = $row["promo"];
					echo "<h2>Promotion : <select onRealease = 'filtrer(this)'>";
					echo "<option id = 'promo' name='$promo'>$promo</option>";

				while ($row = pg_fetch_array($result))
				{
					$prom = $row["promo"];
					
					echo "<option id = 'promo' name='$prom'>$prom</option>";
				}
				echo "</select></h2>";
					
					echo "<div id='table_stat'><h2>Moyenne de cette promo :".moyennePromotionMatiere($promo, $idMatiere)."%</h2>";
					echo "<table class='border' style='margin: auto; text-align:right;'>
						<tr>
							<td> Rang </td>
							<td> Nom </td>
							<td> Moyenne </td>
						</tr>";
						
					$result = pg_query($dbcon, requete_etudiants_participants_par_matiere($promo,$idMatiere));
					while ($row = pg_fetch_array($result)) {
						
						$idEtu=$row['idetudiant'];
						$res_nom = pg_query($dbcon,requete_nom_prenom_etudiant($idEtu));
						$row_nom = pg_fetch_array($res_nom);
						$nom_etu =$row_nom['nometudiant'];
						$prenom_etu =$row_nom['prenometudiant'];
						$res_ranknb = pg_query($dbcon, requete_nb_etudiant_d_une_promo($promo));
						$rownb = pg_fetch_array($res_ranknb);
						$ranknb = $rownb['count'];
						echo "<tr>
							<td>" . rangEtudiantMatiere($idEtu, $idMatiere) . "/" . $ranknb . " </td>
							<td> " . $nom_etu ." ". $prenom_etu . " </td>
							<td> " . moyenneMatiere($idEtu, $idMatiere) . "% </td>
						</tr>";
					}

					echo "</table></div>";
				}

			}
			?>
		</div>
	</body>
</html>