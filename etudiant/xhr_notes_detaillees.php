<?php
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
include '../session/fonctions_resultats.php';
session_start();
date_default_timezone_set("Europe/Paris");
//var_dump($_POST);
$idMatiere = $_POST['idMatiere'];

if ((!isset($_SESSION["id"])) || !($_SESSION["statut"] == "etu")) {
	header('Location:../index.php');
} else {
	$idEtu = $_SESSION["id"];

	$dbcon = connexionBDD();

	if (!$dbcon) {
		echo "connection BDD failed<br>";
	} else {
		$result = pg_query($dbcon, requete_nombre_de_sessions_d_un_etudiant($idEtu));
		$row = pg_fetch_array($result);
		$totalSession = $row["count"];

		$resPromo = pg_query($dbcon, requete_promo_d_un_etudiant($idEtu));
		$rowP = pg_fetch_array($resPromo);
		$promo = $rowP['promo'];

		$res_ranknb = pg_query($dbcon, requete_nb_etudiants_participants_par_matiere($promo,$idMatiere));
		$rownb = pg_fetch_array($res_ranknb);
		$ranknb = $rownb['count'];

		echo "<table class='liste' style='margin: auto; width:98%;'>
						<thead>
							<th> Date de la session </th>
							<th> Ma note </th>							
							<th> Moyenne de la promotion </th>
							<th> Classement </th>
						</thead>
						<tr>
							<td> Toutes </td>
							<td> " . moyenneMatiere($idEtu, $idMatiere) . "% </td>
							<td> " . moyennePromotionMatiere($promo,$idMatiere) . "% </td>
							<td> " . rangEtudiantMatiere($idEtu, $idMatiere) . "/" . $ranknb . " </td>
						</tr>";

		$result = pg_query($dbcon, requete_sessions_d_un_etudiant_par_matiere($idEtu, $idMatiere));
		while ($row = pg_fetch_array($result)) {
			$date = $row["datesession"];

			$res_ranknb = pg_query($dbcon, requete_nb_etudiants_participants($date));
			$rownb = pg_fetch_array($res_ranknb);
			$ranknb = $rownb['count'];
			echo "<tr>
							<td>" . date("Y-m-d H:i", $date) . "</td>
							<td> " . noteSession($idEtu, $date) . "% </td>
							<td> " . moyenneSession($date) . "% </td>
							<td> " . rangEtudiant($idEtu, $date) . "/" . $ranknb . " </td>
						</tr>";
		}

		echo "</table>";
	}

}
?>