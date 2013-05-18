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

		<script>
			$(function() {
				$("#selectable").selectable({
					stop : function() {
						var result = $("#select-result").empty();
						$(".ui-selected", this).each(function() {
							var index = $("#select-result").val();
							//$("#selectable li").index(this);

							result.append("#" + (index));
							//$(this).load('session.php', {selectable: $('#select-result').html()});
						});
					}
				});
			});
		</script>
		<script></script>

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
			$session = $_SESSION['idSession'];
			//var_dump($_POST);
			//var_dump($_SESSION);
			if (isset($_POST['precedent'])) {
				if ($_SESSION['Curseur'] > 1)
					$_SESSION['Curseur']--;
				unset($_POST['precedent']);

				// j'ai cliqué sur « Précedent »
				$dbcon = pg_connect("host=$host user=$login password=$password");

				if (!$dbcon) {
					echo "La connexion à la base de donnée a été perdue<br>";
				} else {

					$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, questions.tempsquestion 
			FROM   quiz, questions, inclu, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session;");

					for ($i = 0; $i < $_SESSION['Curseur']; $i++) {
						$array = pg_fetch_array($result) or die("Echec de la requete3");
					}

					//var_dump($array);
					$question = $array['libellequestion'];
					$idQuestion = $array['idquestion'];
					$tempquestion = $array['tempsquestion'];
					//$_SESSION['QuestionCourrante']=$idQuestion;
					$array = pg_fetch_array($result) or die("Echec de la requete4");
					$idQuestionSuivante = $array['idquestion'];
					//$_SESSION['QuestionSuivante']=$idQuestionSuivante;

					echo '<br><br>Vous avez séléctioné les réponses suivantes : <span id="elect-result"></span>
			<form method="post" action="session.php">
				<h1 class="question">' . $question . ' ? :</h1>
				<ol id="selectable">';
					$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, reponses.idreponse, reponses.libellereponse, questions.tempsquestion 
			FROM   quiz, questions, inclu, reponses, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  reponses.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session
			AND	  reponses.idquestion =$idQuestion;");
					while ($array = pg_fetch_array($result)) {

						$reponse = $array['libellereponse'];

						//idquestion suivante
						//$array = pg_fetch_array($result);
						//$idQuestionSuivante = $array['idquestion'];
						//$_SESSION['QuestionSuivante']=$idQuestionSuivante;

						echo '<li class="ui-widget-content">' . $reponse . '</li>';

					}

				}

			} elseif (isset($_POST['suivant'])) {
				$_SESSION['Curseur']++;
				//$selectable = $_POST['selectable'];
				//echo "$selectable";
				unset($_POST['suivant']);

				if ($_SESSION['NbdeQuestions'] + 1 > $_SESSION['Curseur']) {

					// j'ai cliqué sur « Suivant »
					$dbcon = pg_connect("host=$host user=$login password=$password");

					if (!$dbcon) {
						echo "La connexion à la base de donnée a été perdue<br>";
					} else {

						$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, questions.tempsquestion 
			FROM   quiz, questions, inclu, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session;");

						for ($i = 0; $i < $_SESSION['Curseur']; $i++) {
							$array = pg_fetch_array($result) or die("Echec de la requete5");
						}

						
						$question = $array['libellequestion'];
						$idQuestion = $array['idquestion'];
						$tempquestion = $array['tempsquestion'];

						echo '<br><br>Vous avez séléctioné les réponses suivantes : <span id="elect-result"></span>
			<form method="post" action="session.php">
				<h1 class="question">' . $question . ' ? :</h1>
				<ol id="selectable">';
						$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, reponses.idreponse, reponses.libellereponse, questions.tempsquestion 
			FROM   quiz, questions, inclu, reponses, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  reponses.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session
			AND	  reponses.idquestion =$idQuestion;");
						while ($array = pg_fetch_array($result)) {

							$reponse = $array['libellereponse'];

							echo '<li class="ui-widget-content">' . $reponse . '</li>';

						}

					}

				} else {
					header('Location:../session/resultats.php');
				}

			} else {

				$_SESSION['Curseur'] = 1;

				// j'arrive sur la page
				$dbcon = pg_connect("host=$host user=$login password=$password");

				if (!$dbcon) {
					echo "La connexion à la base de donnée a été perdue<br>";
				} else {

					$result = pg_query($dbcon, "SELECT COUNT(*)
	FROM Questions, Inclu, Quiz, Sessions
	WHERE	Questions.idQuestion = Inclu.idQuestion
	AND Quiz.idQuiz = Inclu.idQuiz
	AND	sessions.idquiz = inclu.idquiz 
	AND	  sessions.datesession = $session;");
					$array = pg_fetch_array($result) or die("Echec de la requete7");
					//var_dump($array);

					$_SESSION['NbdeQuestions'] = $array['count'];

					$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, questions.tempsquestion 
			FROM   quiz, questions, inclu, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session;");

					$array = pg_fetch_array($result) or die("Echec de la requete1");
					//var_dump($array);
					$question = $array['libellequestion'];
					$idQuestion = $array['idquestion'];

					echo '<br><br>Vous avez séléctioné les réponses suivantes : <span id="elect-result"></span>
			<form method="post" action="session.php">
				<h1 class="question">' . $question . ' ? :</h1>
				<ol id="selectable">';
					$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, reponses.idreponse, reponses.libellereponse, questions.tempsquestion 
			FROM   quiz, questions, inclu, reponses, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  reponses.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session
			AND	  reponses.idquestion =$idQuestion;");
					while ($array = pg_fetch_array($result)) {

						$reponse = $array['libellereponse'];

						echo '<li class="ui-widget-content">' . $reponse . '</li>';

					}

				}

			}
			?>

			</ol>
			<input id="select-result" type="hidden" name="reponse" value=""/>
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

