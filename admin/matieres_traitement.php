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
//Si le formulaire matiere a été validé avec le bouton d'ajout et que la matiere est différente du prérempli
if (isset($_POST['nomMatiere'])) {
	if (($_POST['nomMatiere'] != 'Ex:"SQL"') && isset($_POST['add'])) {
		unset($_POST['add']);
		//ajout de la matiere
		$result = pg_query($dbcon, requete_insertion_matiere(pg_escape_string($_POST['nomMatiere'])));
		header('Location:matieres.php');
	//sinon si le bouton d'effacement a été appuyé
	} elseif (isset($_POST['del'])) {
		unset($_POST['del']);
		unset($_POST['nomMatiere']);
		//pour toute matiere cochée on la supprime
		foreach ($_POST as $key => $idMatiere) {
			$result = pg_query($dbcon, requete_effacement_matiere($idMatiere));
			header('Location:matieres.php');
		}
	}
	//si le bouton associe a été appuyé
} elseif (isset($_POST['associe'])) {
	//associer prof a matière
	$result = pg_query($dbcon, requete_associer_prof_a_matiere($idAdminProf, $idMatiere));
	//header('Location:matieres.php');
	//si le bouton dissocie a été appuyé
} elseif (isset($_POST['dissocie'])) {
	//dissocier prof a matière
	$result = pg_query($dbcon, requete_dissocier_prof_a_matiere($idAdminProf, $idMatiere));
	//header('Location:matieres.php');
}
?>