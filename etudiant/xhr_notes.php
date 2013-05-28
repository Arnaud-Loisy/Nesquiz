<?php
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
include '../session/fonctions_resultats.php';
session_start();
date_default_timezone_set("Europe/Paris");

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

		$res_ranknb = pg_query($dbcon, requete_nb_etudiant_d_une_promo($promo));
		$rownb = pg_fetch_array($res_ranknb);
		$ranknb = $rownb['count'];

		echo "<table class='liste' id='table_stat' style='margin: auto; width:98%;'>
						<thead>
							<th> Matière </th>
							<th> Ma Moyenne </th>
							<th> Nombre de sessions </th>
							<th> Moyenne de la promotion </th>
							<th> Classement </th>
						</thead>
						<tr>
							<td> Toutes </td>
							<td> " . moyenneGenerale($idEtu) . "% </td>
							<td>" . $totalSession . "</td>
							<td> " . moyenneGeneralePromotion($promo) . "% </td>
							<td> " . rangEtudiantGeneral($idEtu) . "/" . $ranknb . " </td>
						</tr>";

		$result = pg_query($dbcon, requete_toutes_matieres_d_un_etudiant($idEtu));
		while ($row = pg_fetch_array($result)) {
			$libelleMatiere = $row["libellematiere"];
			$idMatiere = $row["idmatiere"];
			$result_nbSession = pg_query($dbcon, requete_nombre_de_sessions_d_un_etudiant_matiere_donnee($idEtu, $idMatiere));
			$nbSession = pg_fetch_array($result_nbSession);

			$res_ranknb = pg_query($dbcon, requete_nb_etudiants_participants_par_matiere($promo,$idMatiere));
			$rownb = pg_fetch_array($res_ranknb);
			$ranknb = $rownb['count'];
			echo "<tr>
							<td>" . $libelleMatiere . "</td>
							<td> " . moyenneMatiere($idEtu, $idMatiere) . "% </td>
							<td>" . $nbSession['count'] . "</td>
							<td> " . moyennePromotionMatiere($promo,$idMatiere) . "% </td>
							<td> " . rangEtudiantMatiere($idEtu, $idMatiere) . "/" . $ranknb . " </td>
						</tr>";
		}

		echo "</table>";
	}

}
?>