<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Traitement publication</title>
		<link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
	</head>
	<body>
		<div id='page'>

			<?php
			session_start();
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';
			if (!(isset($_SESSION["id"]))) {
				header('Location:../index.php');
			}
			$dateSession = $_POST['idSession'];
			$passSession = $_POST['passquiz'];

			$dbcon = connexionBDD();
			if (!$dbcon) {
				echo "<br><br>connection échouée à la BDD<br>";
			} else {

				$result = pg_query($dbcon, requete_mdp_etat_session($dateSession));
				$array = pg_fetch_array($result);

				if (($_POST["passquiz"] != "") && ($passSession == $array['mdpsession'])) {
					$id = $_SESSION["id"];
					$_SESSION['idSession'] = $dateSession;

					$result = pg_query($dbcon, requete_participer_a_une_session($id, $dateSession));
					// or die("Vous êtes déja connecté");
					//$array = pg_fetch_array($result);
					var_dump($result);
					if ($result) {
						header('Location:../session/session_pause.php');
					} else {
						$_SESSION['done'] = 1;
						
						header('Location:../etudiant/listequiz.php');
					}

				} else {
					$_SESSION['badpw'] = 1;
					//var_dump($array);
					header('Location:../etudiant/listequiz.php');
				}
			}
			?>
		</div>
	</body>
</html>