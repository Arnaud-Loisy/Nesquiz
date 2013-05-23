
			<?php
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';
			include '../session/fonctions_resultats.php';
			session_start();
			date_default_timezone_set("Europe/Paris");
			var_dump($_POST);

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
				$libelleMatiere="MAths";
				echo "<h1 >$libelleMatiere :</h1>";
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
				
				$resPromo = pg_query($dbcon, requete_promo_d_un_etudiant($idEtu));
					$rowP = pg_fetch_array($resPromo);
					$promo = $rowP['promo'];
				
				$res_ranknb = pg_query($dbcon,requete_nb_etudiant_d_une_promo($promo));
					$rownb = pg_fetch_array($res_ranknb);
					$ranknb=$rownb['count'];
				
				
				
				
				echo "<br><br><br><br><table style='margin: 0; text-align:right;'>
						<tr>
							<td> Date de la session </td>
							<td> Ma note </td>							
							<td> Moyenne de la promotion </td>
							<td> Classement </td>
						</tr>
						<tr>
							<td> Toutes </td>
							<td> ".moyenneMatiere($idEtu,$idMatiere)."% </td>
							<td> ".moyennePromotionMatiere($promo, $idMatiere)."% </td>
							<td> ".rangEtudiantMatiere($idEtu, $idMatiere)."/".$ranknb." </td>
						</tr>";
						
				$result = pg_query($dbcon,requete_sessions_d_un_etudiant_par_matiere($idEtu, $idMatiere));
				while ($row = pg_fetch_array($result))
				{
					$date = $row["datesession"];
					
					$res_ranknb = pg_query($dbcon,requete_nb_etudiant_d_une_promo($promo));
					$rownb = pg_fetch_array($res_ranknb);
					$ranknb=$rownb['count'];
					echo "<tr>
							<td>".date("Y-m-d H:i",$date)."</td>
							<td> ".noteSession($idEtu, $date)."% </td>
							<td> ".moyenneSession($date)."% </td>
							<td> ".rangEtudiant($idEtu, $date)."/".$ranknb." </td>
						</tr>";
				}
						
						echo "</table>";
			}
			
			?>