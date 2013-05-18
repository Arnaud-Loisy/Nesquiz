<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Liste des quiz en cours</title>
		<link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

	</head>
	<body>
		<div id='page'>
			<?php
			session_start();
			date_default_timezone_set("Europe/Paris");
			include '../accueil/menu.php';
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';

			if (isset($_SESSION["badpw"])) {
				echo "<br><br><h1>Mauvais mot de passe.</h1>";
				unset($_SESSION['badpw']);
			}
			if (isset($_SESSION["done"])) {
				echo "<br><br><h1>vous avez déja partipé à cette session.</h1>";
				unset($_SESSION['done']);
			}
			

			$dbcon = connexionBDD();
			if (!$dbcon) {
				echo "<br><br>connection échouée à la BDD<br>";
			} else {
				echo "<br><br>";
				

				$result = pg_query($dbcon, requete_liste_session_ouvertes());
				
				echo '<form action="/session/participer.php" method="POST" style="text-align: center;">';
				
				echo "<select name='idSession'>";

				$i = 0;
				while ($row = pg_fetch_array($result)) {
					$libelle = $row["libellequiz"];
					$id = $row["datesession"];
					echo "<option value=$id>$libelle : ".date("Y-m-d H:i",$id)."</option>";
					$i++;
				}
				
				echo "</select>"; 
				echo ' <br> Mot de Passe : <input type="text" name="passquiz" /><br>';
				echo "<input class='boutonCenter' type='submit' value='Participer'>";
				
				echo "</form>";
				
			}
			?>
		</div>
	</body>
</html>