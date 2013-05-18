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
			include '../admin/secret.php';

			if (isset($_SESSION["badpw"])) {
				echo "<br><br><h1>Mauvais mot de passe.</h1><br>";
				unset($_SESSION['badpw']);
			}
			if (isset($_SESSION["done"])) {
				echo "<br><br><h1>vous avez déja partipé à cette session.</h1><br><br>";
				unset($_SESSION['done']);
			}
			

			$dbcon = pg_connect("host=$host user=$login password=$password");
			if (!$dbcon) {
				echo "<br><br>connection échouée à la BDD<br>";
			} else {
				echo "<br><br>";
				$requete = "SELECT libelleQuiz,datesession	FROM Sessions, Quiz	WHERE Sessions.idQuiz = Quiz.idQuiz	AND Sessions.etatsession=1;";

				$result = pg_query($dbcon, $requete);
				echo "<form action ='/session/participer.php' method='POST'>";
				
				echo "<select name='idSession'>";

				$i = 0;
				while ($row = pg_fetch_array($result)) {
					$libelle = $row["libellequiz"];
					$id = $row["datesession"];
					echo "<option value=$id>$libelle : ".date("Y-m-d H:i",$id)."</option>";
					$i++;
				}
				
				echo "</select>"; 
				echo '  Mot de Passe : <input type="text" name="passquiz" /><br>';
				echo "<input class='boutonCenter' type='submit' value='Participer'>";
				
				echo "</form>";
				
			}
			?>
		</div>
	</body>
</html>