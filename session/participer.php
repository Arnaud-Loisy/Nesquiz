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
			$idSession = $_POST['idSession'];
			$passSession = $_POST['passquiz'];
			include '../admin/secret.php';
			$dbcon = pg_connect("host=$host user=$login password=$password");
			if (!$dbcon) {
				echo "<br><br>connection échouée à la BDD<br>";
			} else {
				$requete = "SELECT mdpsession FROM Sessions	WHERE datesession =$idSession";

				$result = pg_query($dbcon, $requete);
				$row = pg_fetch_array($result);

				session_start();
				if (!(isset($_SESSION["id"]))) {
					header('Location:../index.php');
				}

				if (($_POST["passquiz"] != "") && ($passSession == $row['mdpsession'])) {
					$id=$_SESSION["id"];
					$_SESSION['idSession'] = $idSession;
					$requete="INSERT INTO PARTICIPE values (".$id.",".$idSession."); ";
					$result = pg_query($dbcon, $requete) or die("Echec de la requete"); 
					
					header('Location:../session/session.php');

				} else {
					$_SESSION['badpw'] = 1;
					header('Location:../etudiant/listequiz.php');
				}
			}
			?>
		</div>
	</body>
</html>