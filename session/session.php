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
							var index = $("#selectable li").index(this);
							result.append((index));
							$(this).load('session.php', {selectable: $('#select-result').html()});
						});
					}
				});
			});
		</script>
		<script>
			
		</script>

	</head>
	<body>
		<div id='page'>
			<?php
			session_start();
			include '../accueil/menu.php';
			include '../admin/secret.php';
			$session = $_SESSION['idSession'];
			if (isset($_POST['precedent'])) {

				// j'ai cliqué sur « Précedent »
				var_dump($_POST);

			} elseif (isset($_POST['suivant'])) {
				//$selectable = $_POST['selectable'];
				//echo "$selectable";
				$_SESSION['QuestionPrecedente']=$_SESSION['QuestionCourrante'];
				$_SESSION['QuestionCourrante']=$_SESSION['QuestionSuivante'];
				var_dump($_POST);
				

				// j'ai cliqué sur « Suivant »

			} else {
				
				var_dump($_POST);
				// j'arrive sur la page 

			}
			$dbcon = pg_connect("host=$host user=$login password=$password");

			if (!$dbcon) {
				echo "La connexion à la base de donnée a été perdue<br>";
			} else {
				$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, reponses.idreponse, reponses.libellereponse, questions.tempsquestion 
			FROM   quiz, questions, inclu, reponses, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  reponses.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz 
			AND	  sessions.datesession = $session;");

				$array = pg_fetch_array($result) or die("Echec de la requete") ;				
				//var_dump($array);
				$question = $array['libellequestion'];
				$idQuestion = $array['idquestion'];
				$_SESSION['QuestionCourrante']=$idQuestion;
				$reponse = $array['libellereponse'];
				echo '<br><br>Vous avez séléctioné les réponses suivantes : <span id="select-result"></span>
			<form method="post" action="session.php">
				<h1 class="question">' . $question . ' ? :</h1>
				<ol id="selectable">';

				while ($idQuestion == $array['idquestion']) {
					$array = pg_fetch_array($result);
					$reponse = $array['libellereponse'];
					
					//idquestion suivante 
					$array = pg_fetch_array($result);
					$idQuestionSuivante = $array['idquestion'];
					$_SESSION['QuestionSuivante']=$idQuestionSuivante;
					
					echo '<li class="ui-widget-content">' . $reponse . '</li>';
				}

			}
			?>

			</ol>
			
<input class="bouton" type="submit" name="precedent" value="Précédent" />
<input class="bouton" type="submit" name="suivant" value="Suivant" />
			

			</form>

		</div>
	</body>
</html>

