<?php
session_start();
var_dump($_POST);
var_dump($_SESSION);
include '../bdd/connexionBDD.php';
include '../bdd/requetes.php';
$dbcon = connexionBDD();

if(isset($_POST['idMatiere']))
{
	$idMatiere=$_POST['idMatiere'];
}
if(isset($_POST['idAdminProf'])){
	$idAdminProf=$_POST['idAdminProf'];
}

if (isset($_POST['nomMatiere'])) {
	if (($_POST['nomMatiere'] != 'Ex:"SQL"') && isset($_POST['add'])) {
		unset($_POST['add']);
		$result = pg_query($dbcon, requete_insertion_matiere($_POST['nomMatiere']));
		header('Location:matieres.php');

	} elseif (isset($_POST['del'])) {
		unset($_POST['del']);
		unset($_POST['nomMatiere']);

		foreach ($_POST as $key => $idMatiere) {
			$result = pg_query($dbcon, requete_effacement_matiere($idMatiere));
			header('Location:matieres.php');
		}
	}
} elseif (isset($_POST['associe'])) {
	
	$result = pg_query($dbcon, requete_associer_prof_a_matiere($idAdminProf, $idMatiere));
	//header('Location:matieres.php');
} elseif (isset($_POST['dissocie'])) {
	
	$result = pg_query($dbcon, requete_dissocier_prof_a_matiere($idAdminProf, $idMatiere));
	//header('Location:matieres.php');
}
?>