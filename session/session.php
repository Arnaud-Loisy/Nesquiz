<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Session</title>
		<link rel="stylesheet" href="..\styles\jquery-ui.css" />
		<script src="..\scripts\jquery-2.0.0.js"></script>
		<script src="..\scripts\jquery-ui.js"></script>
		<link rel="stylesheet" href="..\styles\theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

		<script>
			$(function() {
    $( "#selectable" ).selectable({
      stop: function() {
        var result = $( "#select-result" ).empty();
        $( ".ui-selected", this ).each(function() {
          var index = $( "#selectable li" ).index( this );
          result.append( " #" + ( index ) );
        });
      }
    });
  });
		</script>

	</head>
	<body>
		<div id='page'>
			<?php
			include '../accueil/menu.php';
			include '../admin/secret.php';
			$session=11111111;
			$dbcon=pg_connect("host=$host user=$login password=$password");

			if(!$dbcon){
 				echo "connection failed<br>";
			}else
				echo "connection not failed<br>";

			$result = pg_query($dbcon, "SELECT questions.idquestion, questions.libellequestion, reponses.idreponse, reponses.libellereponse, questions.tempsquestion 
			FROM   quiz, questions, inclu, reponses, sessions
			WHERE 	  quiz.idquiz = inclu.idquiz 
			AND	  inclu.idquestion = questions.idquestion 
			AND	  reponses.idquestion = questions.idquestion 
			AND	  sessions.idquiz = inclu.idquiz;");
			
			
			$array = pg_fetch_array($result);
			echo '<span id="select-result"></span>.
			<form method="post" action="session.php">
				<h1 class="question">Que veux dire le sigle ARP ? :</h1>
				<ol id="selectable">'
			?>
			
					<li class="ui-widget-content">Address Research Protocol</li>
					<li class="ui-widget-content">Address Resolution Protocol</li>
					<li class="ui-widget-content">Addressing Research Protocol</li>
					<li class="ui-widget-content">Addressing Resolution Protocol</li>
				</ol>
				<input class="bouton" type="submit" value="Précédent" />
				<input class="bouton" type="submit" value="Suivant" />
				
			</form>
			
			
		</div>
	</body>
</html>

