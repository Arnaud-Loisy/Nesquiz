<?php
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
include '../session/fonctions_resultats.php';
session_start();
date_default_timezone_set("Europe/Paris");
$idMatiere = $_POST['idMatiere'];
$promo =  $_POST['promo'];
//$promo = $_POST['promo'];
if ((!isset($_SESSION["id"])) || ($_SESSION["statut"] == "etu")) {
	header('Location:../index.php');
} else {
	$idEtu = $_SESSION["id"];

	$dbcon = connexionBDD();

	if (!$dbcon) {
		echo "connection BDD failed<br>";
	} else {
		echo "<div id='table_stat'><h2>Moyenne de cette promo :".moyennePromotionMatiere($promo, $idMatiere)."%</h2>";
		echo "<table class='liste' id='table_stat' style='margin: auto;min-width:60%;'>
						<thead>
							<th> Rang </th>
							<th> Nom </th>
							<th> Moyenne </th>
						</thead>";
						
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

					echo "</table>";
	}

}
?>