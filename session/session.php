<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Session</title>
		<link rel="stylesheet" href="../styles/jquery-ui.css" />
		<script src="../scripts/jquery-2.0.0.js"></script>
		<script src="../scripts/jquery-ui.js"></script>
		<link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
	</head>
	<body>
		<div id='page'>
			<?php
			session_start();
			if (!(isset($_SESSION["id"]))) {
				header('Location:../index.php');
			}

			include '../accueil/menu.php';
			include '../admin/secret.php';
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';
			$dateSession = $_SESSION['idSession'];
			$id=$_SESSION['id'];
			//DEBUG
			//var_dump($_POST);
			//var_dump($_SESSION);
			if (isset($_POST['precedent'])) {
				if ($_SESSION['Curseur'] > 1)
					$_SESSION['Curseur']--;
				unset($_POST['precedent']);

				// j'ai cliqué sur « Précedent »
				$dbcon = connexionBDD();

				if (!$dbcon) {
					echo "La connexion à la base de donnée a été perdue<br>";
				} else {

					$result = pg_query($dbcon, requete_questions_d_une_session($dateSession));

					//positionne sur la bonne question
					for ($i = 0; $i < $_SESSION['Curseur']; $i++) {
						$array = pg_fetch_array($result) or die("Echec de la requete3");
					}

					//On met la question courrante dans des variables
					$question = $array['libellequestion'];
					$idQuestion = $array['idquestion'];
					$tempquestion = $array['tempsquestion'];

					echo '<br><br>
					<form method="post" action="session.php">
					<h1 class="question">' . $question . ' ? :</h1>
					<input type="hidden" name="Question" value="' . $idQuestion . '"/>';
					
					$result = pg_query($dbcon, requete_reponses_d_une_question_d_une_session($dateSession, $idQuestion));
					while ($array = pg_fetch_array($result)) {

						$reponse = $array['libellereponse'];

						$idreponse = $array['idreponse'];

						//echo '<li class="ui-widget-content">' . $reponse . '</li>';
						echo '<input type="checkbox" name="' . $idreponse . '" value="' . $idreponse . '"/>' . $reponse . '<br>';
						//echo '<li class="ui-widget-content">' . $reponse . '</li>';

					}

				}

			} elseif (isset($_POST['suivant'])) {
				$_SESSION['Curseur']++;
				$SQLQuestion = $_POST['Question'];
				unset($_POST['Question']);
				unset($_POST['suivant']);

				if ($_SESSION['NbdeQuestions'] + 1 > $_SESSION['Curseur']) {

					// j'ai cliqué sur « Suivant »
					$dbcon = connexionBDD();

					if (!$dbcon) {
						echo "La connexion à la base de donnée a été perdue<br>";
					} else {

						$result = pg_query($dbcon, requete_questions_d_une_session($dateSession));

						for ($i = 0; $i < $_SESSION['Curseur']; $i++) {
							$array = pg_fetch_array($result) or die("Echec de la requete5");
						}

						$question = $array['libellequestion'];
						$idQuestion = $array['idquestion'];
						$tempquestion = $array['tempsquestion'];

						echo '<br><br>
						<form method="post" action="session.php">
						<h1 class="question">' . $question . ' ? :</h1>
						<input type="hidden" name="Question" value="' . $idQuestion . '"/>';

						$result = pg_query($dbcon, requete_reponses_d_une_question_d_une_session($dateSession, $idQuestion));

						$i = 0;
						while ($array = pg_fetch_array($result)) {

							$reponse = $array['libellereponse'];
							$idreponse = $array['idreponse'];

							//echo '<li class="ui-widget-content">' . $reponse . '</li>';
							echo '<input type="checkbox" name="' . $i . '" value="' . $idreponse . '"/>' . $reponse . '<br>';
							$i++;

						}
						$result = pg_query($dbcon,efface_les_reponses_d_une_question_d_une_session_d_un_etudiant ($SQLQuestion,$id,$dateSession));
						foreach ($_POST as $key => $SQLreponse) {
							
							$result = pg_query($dbcon, insertion_des_reponses_choisies($SQLQuestion,$SQLreponse,$id,$dateSession));

						}

					}

				} else {
					$dbcon = connexionBDD();

					if (!$dbcon) {
						echo "La connexion à la base de donnée a été perdue<br>";
					} else {
						$result = pg_query($dbcon,efface_les_reponses_d_une_question_d_une_session_d_un_etudiant ($SQLQuestion,$id,$dateSession));
						foreach ($_POST as $key => $SQLreponse) {
							
							$result = pg_query($dbcon, insertion_des_reponses_choisies($SQLQuestion,$SQLreponse,$id,$dateSession));

						}
						header('Location:../session/resultats.php');
					}
				}

			} else {

				$_SESSION['Curseur'] = 1;

				// j'arrive sur la page
				$dbcon = connexionBDD();

				if (!$dbcon) {
					echo "La connexion à la base de donnée a été perdue<br>";
				} else {

					$result = pg_query($dbcon, requete_nb_de_questions_d_une_session($dateSession));
					$array = pg_fetch_array($result) or die("Echec de la requete7");
					//var_dump($array);

					$_SESSION['NbdeQuestions'] = $array['count'];

					$result = pg_query($dbcon, requete_questions_d_une_session($dateSession));

					$array = pg_fetch_array($result) or die("Echec de la requete1");
					//var_dump($array);
					$question = $array['libellequestion'];
					$idQuestion = $array['idquestion'];

					echo '<br><br>
					<form method="post" action="session.php">
					<h1 class="question">' . $question . ' ? :</h1>
					<input type="hidden" name="Question" value="' . $idQuestion . '"/>';

					$result = pg_query($dbcon, requete_reponses_d_une_question_d_une_session($dateSession, $idQuestion));
					while ($array = pg_fetch_array($result)) {

						$reponse = $array['libellereponse'];
						$idreponse = $array['idreponse'];

						//echo '<li class="ui-widget-content">' . $reponse . '</li>';
						echo '<input type="checkbox" name="' . $idreponse . '" value="' . $idreponse . '"/>' . $reponse . '<br>';

					}

				}

			}
			?>

			<input class="bouton" type="submit" name="precedent" value="Précédent" />
			<input class="bouton" type="submit" name="suivant" value="Suivant" />

			</form>
		</div>
		<?php
		//DEBUG
		//var_dump($_POST);
		//var_dump($_SESSION);
		?>
	</body>
</html>

