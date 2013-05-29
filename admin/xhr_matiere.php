<?php
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
session_start();
date_default_timezone_set("Europe/Paris");
$idMatiere = $_POST['idMatiere'];
//$promo = $_POST['promo'];
if ((!isset($_SESSION["id"])) || (!($_SESSION["statut"] == "admin"))) {
	header('Location:../index.php');
} else {
	$idAdmin = $_SESSION["id"];

	$dbcon = connexionBDD();

	if (!$dbcon) {
		echo "connection BDD failed<br>";
	} else {
		echo "<table style='width: 100%;' class = 'liste listeScrollable' id = 'table_profs'>";
				echo "<thead style='display: table-header-group;'><th>Nom Prénom</th></thead>";
				echo "<tbody>";
				$result = pg_query($dbcon,requete_idadminprof_d_une_matiere($idMatiere));
				while ($row=pg_fetch_array($result)) {
					echo "<tr>
							<td id='".$row['idadminprof']."' style='width: 720px'>" . $row['nomadminprof'] ." ".$row['prenomadminprof']. " </td>							
						</tr>";
				}

				
				echo "</tbody>";
				echo "</table>";
	}

}
?>