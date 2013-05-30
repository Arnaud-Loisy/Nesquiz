<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=830">
		<title>Session</title>
		<link rel="stylesheet" href="../styles/theme.css" />
	</head>
	<body>
		<div id='page'>
			<?php
			session_start();
			if (!isset($_SESSION["id"]) || (!isset($_SESSION['idSession']))) {
				header('Location:../index.php');
			}

			include '../accueil/menu.php';
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';
			$dateSession=$_SESSION['idSession'];
			$dbcon = connexionBDD();
			if (!$dbcon) {
				echo "<br><br>connection échouée à la BDD<br>";
			} else {

				$result = pg_query($dbcon, requete_mdp_etat_session($dateSession));
				$array = pg_fetch_array($result);
				if($array['etatsession']==1){
					echo "<br><br><br><h1> En attente du lancement de la session</h1>";
				header("refresh: 5; url=session_pause.php");
			}else{
				header('Location:../session/session.php');
			}
			
			}
			?>
		</div>
	</body>
</html>
