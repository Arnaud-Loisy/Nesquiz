<?php
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
include '../session/fonctions_resultats.php';
session_start();
date_default_timezone_set("Europe/Paris");
$idMatiere = $_POST['idMatiere'];
$promo =  $_POST['promo'];
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
				echo "<thead><th>Nom Prénom</th></thead>";
				//echo "<tbody>";
				$result = pg_query($dbcon,requete_tous_idadminprof_nomadminprof_prenomadminprof());
				while ($row=pg_fetch_array($result)) {
					echo "<tr>
							<td id='".$row['idadminprof']."'>" . $row['nomadminprof'] ." ".$row['prenomadminprof']. " </td>							
						</tr>";
				}

				
				//echo "</tbody>";
				echo "</table>";
	}

}
?>