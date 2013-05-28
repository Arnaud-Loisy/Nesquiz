<?php
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
include '../session/fonctions_resultats.php';
session_start();
date_default_timezone_set("Europe/Paris");

if ((!isset($_SESSION["id"])) || (!($_SESSION["statut"] == "admin"))) {
	header('Location:../index.php');
} else {
	$idAdmin = $_SESSION["id"];

	$dbcon = connexionBDD();

	if (!$dbcon) {
		echo "connection BDD failed<br>";
	} else {
		echo "<table style='width: 100%;' class = 'liste' id = 'table_matiere'>";
				echo "<thead style='width: 100%;'><th>Matière</th><th>Supprimer</th></thead>";
				echo "<tbody style='width: 100%;' >";
				
				$result = pg_query($dbcon,requete_matieres());
				while ($row=pg_fetch_array($result)) {
					echo "<tr>
							<td>" . $row['libellematiere'] . " </td>
							<td> <input type='checkbox' value='".$row['idmatiere']."'> </td>
						</tr>";
				}
				
				echo "</tbody>";
				echo "</table>";
	}

}
?>