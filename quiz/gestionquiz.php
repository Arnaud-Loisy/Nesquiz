<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Gestion des Quiz</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

        <script type='text/javascript'>

			var currentRow = -1;
			function SelectRow(newRow, maxColLength)
			{
				for (var i = 1; i < maxColLength; ++i)
				{
					var cell = document.getElementById('cell_' + newRow + ',' + i);
					cell.style.background = '#AAF';
					if (currentRow !== -1)
					{
						var cell = document.getElementById('cell_' + currentRow + ',' + i);
						cell.style.background = '#FFF';
					}
				}
				currentRow = newRow;
			}

			function IsSelected()
			{
				return currentRow === -1 ? false : true;
			}

			function GetSelectedRow()
			{
				return currentRow;
			}

			var last_tableRow = -1;

			function InvertColorOfTableLine(tableRow)
			{
				//alert(tableRow.textContent);
				//alert(tableRow.id);
				if (last_tableRow !== -1)
				{
					last_tableRow.style.backgroundColor = "rgb(255, 255, 255)";
				}
				if (tableRow.style.backgroundColor !== "rgb(149,188,242)") {
					tableRow.style.backgroundColor = "rgb(149,188,242)";
				}
				else
				{
					tableRow.style.backgroundColor = "rgb(255, 255, 255)";
				}
				last_tableRow = tableRow;
			}

			function ChangerMatiereEnCours(radioButton)
			{
				//Modification de la liste des questions dans cette matiere
				//var value = oSelect.options[oSelect.selectedIndex].value;	²	
				var value = radioButton.value;
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "xhr_getListeQuestions.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200)) {
						document.getElementById('select_questions_matiere').innerHTML = xhr.responseText;
						//document.getElementById("loader").style.display = "none";
					} /*else if (xhr.readyState < 4) {
					 document.getElementById("loader").style.display = "inline";
					 }*/
				};
				
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdMatiere=" + value);
				
				//Modification de la liste des quiz dans cette matiere
				//var value = oSelect.options[oSelect.selectedIndex].value;	²	
				var xhr2 = new XMLHttpRequest();
				xhr2.open("POST", "xhr_getListeQuizParMatiere.php", true);

				xhr2.onreadystatechange = function() {
					if (xhr2.readyState == 4 && (xhr2.status == 200)) {
						document.getElementById('table_libelles_quiz').innerHTML = xhr2.responseText;
						//document.getElementById("loader").style.display = "none";
					} /*else if (xhr.readyState < 4) {
					 document.getElementById("loader").style.display = "inline";
					 }*/
				};

				xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr2.send("IdMatiere=" + value);
			}

			function ChangerQuizEnCours(ligneTableau)
			{
				//var value = oSelect.options[oSelect.selectedIndex].value;	²	
				var value = ligneTableau.id;
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "xhr_getListeQuestionsParQuiz.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200)) {
						document.getElementById('table_libelles_questions_quiz').innerHTML = xhr.responseText;
						//document.getElementById("loader").style.display = "none";
					} /*else if (xhr.readyState < 4) {
					 document.getElementById("loader").style.display = "inline";
					 }*/
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdQuiz=" + value);
			}

        </script>

    </head>


    <body>

        <div id='page'>

			<?php
			session_start();
			include '../accueil/menu.php';
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';

			$idAdminProf = $_SESSION["id"];

			$dbcon = connexionBDD();

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_matieres_pour_un_professeur($idAdminProf));

				$row = pg_fetch_array($result);
				$libelleMatiere = $row["libellematiere"];
				$idMatiere = $row["idmatiere"];
				
				//echo "<div style='width: 720px;'>";
				echo "<br><h2 style='display: inline-table;' >Mes Matières :</h2>";
				echo "<div style='display: inline-table;' class='radioButtons'>";
				echo "<span><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_".$libelleMatiere."' name='radios_matieres' value='".$idMatiere."' checked='true'/>";
				echo "<label for='radio_".$libelleMatiere."'>".$libelleMatiere."</label></span>";

				while ($row = pg_fetch_array($result))
				{
					$libelleMatiere = $row["libellematiere"];
					$idMatiere = $row["idmatiere"];

					echo "<span class='rightRadioButton'><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_".$libelleMatiere."' name='radios_matieres' value='".$idMatiere."' />";
					echo "<label for='radio_".$libelleMatiere."'>".$libelleMatiere."</label></span>";
				}
				echo "</div>";
			}
			
			echo "<form style='display: table-cell; width 100px;' action = '../session/publication.php' method = 'POST'>";
			echo "<input class = 'bouton' type = 'submit' value = 'Publier'>";
			echo "</form>";
			//echo "</div>";

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_tous_quiz_dans_matiere(1));

				echo "<table class = 'liste' id = 'table_libelles_quiz'>";
				echo "<tbody>";
				echo "<th>Nom du quiz</th>";

				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequiz"];
					$idQuiz = $row["idquiz"];
					echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td>$libelle</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			}

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_questions_dans_quiz(1));

				echo "<table class = 'liste' id = 'table_libelles_questions_quiz'>";
				echo "<tbody>";
				echo "<th>Questions présentes</th>";

				while ($row = pg_fetch_array($result))
				{
					$libelleQuestion = $row["libellequestion"];
					$idQuestion = $row["idquestion"];
					/* echo "<tr><td onclick = 'SelectRow(".$i.", 2)' id = 'cell_".$i.",1'>$libelle</td></tr>"; */
					echo "<tr><td onclick = 'InvertColorOfTableLine(this)' id = '$idQuestion'>$libelleQuestion</td></tr>";
				}
				echo "</tbody>";
				echo "</table><br><br><br><br>";
			}

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_questions_dans_matiere(1));

				echo "<select id='select_questions_matiere'>";

				while ($row = pg_fetch_array($result))
				{
					$libelleQuestion = $row["libellequestion"];
					$idQuestion = $row["idquestion"];
					echo "<option id = '$idQuestion' name='$libelleQuestion'>$libelleQuestion</option>";
				}
				echo "</select>";
			}
			?>   

        </div>
    </body>
</html>
