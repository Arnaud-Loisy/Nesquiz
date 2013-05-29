<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Gestion des Questions</title>
        <link rel="stylesheet" href="../styles/theme.css" />
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

			function InvertColorOfTableLine(tableRow)
			{
				var tableau = tableRow.parentNode.parentNode.id;
				var lignesTableau = tableRow.parentNode.parentNode.getElementsByTagName('tr');

				var i = -1;
				for (i = 0; i < lignesTableau.length; i++)
				{
					lignesTableau[i].style.backgroundColor = "rgb(255, 255, 255)";
				}
				tableRow.style.backgroundColor = "rgb(149, 188, 242)";
			}

			function ChangerMatiereEnCours(radioButton)
			{
				//**
				//Modification de la liste des questions dans cette matiere
				//**
				//var value = oSelect.options[oSelect.selectedIndex].value;	²	
				var value = radioButton.value;
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "xhr_getListeQuestionsParMatiere.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200)) {
						document.getElementById('table_libelles_questions').innerHTML = xhr.responseText;
						//document.getElementById("loader").style.display = "none";
					} /*else if (xhr.readyState < 4) {
					 document.getElementById("loader").style.display = "inline";
					 }*/
				};
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdMatiere=" + value);

				document.getElementById('table_libelles_reponses_questions').innerHTML = "<table class ='TestScrollable' style='width: 500px;' id = 'table_libelles_reponses_questions'>\
																							<thead><th style='min-width: 400px; width: 400px'>Réponse</th><th class='thAuto'>Correcte?</th></thead>\
																							<tbody style='width: 100%'></tbody></table>";
			}

			var idQuestionEnCours = -1;

			function ChangerQuestionEnCours(ligneTableau)
			{
				//var value = oSelect.options[oSelect.selectedIndex].value;	²	
				idQuestionEnCours = ligneTableau.id;
				var value = ligneTableau.id;
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "xhr_getListeReponsesParQuestion.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200)) {
						document.getElementById('table_libelles_reponses_questions').innerHTML = xhr.responseText;
						//document.getElementById("loader").style.display = "none";
					} /*else if (xhr.readyState < 4) {
					 document.getElementById("loader").style.display = "inline";
					 }*/
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdQuestion=" + value);
			}

			function AjouterQuestionAQuiz()
			{
				/**On récupère l'élement html <select>*/
				var select = document.getElementById('select_questions_matiere');
				var idQuestion = select.options[select.selectedIndex].id;
				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_ajoutQuestionAQuiz.php", true);

				xhr.onreadystatechange = function() {
					if ((xhr.readyState == 4) && (xhr.status == 200)) {
						var lignesTableau;
						var i = -1;
						do {
							lignesTableau = document.getElementById('table_libelles_quiz').getElementsByTagName('tr');
							i++;
						} while (lignesTableau[i].id != idQuizEnCours);
						ChangerQuizEnCours(lignesTableau[i]);
					}
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdQuestion=" + idQuestion + "&IdQuiz=" + idQuizEnCours);
			}

			function SupprimerQuestionAQuiz()
			{
				var idQuestion = GetSelectedRowID('table_libelles_questions_quiz');

				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_supprimerQuestionDansQuiz.php", true);

				xhr.onreadystatechange = function() {
					if ((xhr.readyState == 4) && (xhr.status == 200)) {
						var lignesTableauQuiz;
						var i2 = -1;
						do {
							lignesTableauQuiz = document.getElementById('table_libelles_quiz').getElementsByTagName('tr');
							i2++;
						} while (lignesTableauQuiz[i2].id != idQuizEnCours);
						ChangerQuizEnCours(lignesTableauQuiz[i2]);
					}
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdQuestion=" + idQuestion + "&IdQuiz=" + idQuizEnCours);
			}

			function AjouterQuestionAMatiere()
			{
				var libelleQuestion = document.getElementById('input_text_nouvelle_question').value;
				var motsCles = document.getElementById('input_text_mots_cles_nouvelle_question').value;
				var tempsTotal = document.getElementById('input_text_temps_nouvelle_question').value;
				var matieres = document.getElementsByName('radios_matieres');
				var idMatiere;

				for (var i = 0; i < matieres.length; i++)
				{
					if (matieres[i].checked)
						idMatiere = matieres[i].value;
				}

				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_ajoutQuestionAMatiere.php", true);

				xhr.onreadystatechange = function() {
					if ((xhr.readyState == 4) && (xhr.status == 200)) {
						var radios = document.getElementsByName('radios_matieres');
						var i;
						var idRow = -1;

						for (i = 0; i < radios.length; i++)
						{
							if (radios[i].checked)
								idRow = i;
						}

						ChangerMatiereEnCours(radios[idRow]);
					}
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("LibelleQuestion=" + libelleQuestion + "&MotsCles=" + motsCles + "&TempsTotal=" + tempsTotal + "&IdMatiere=" + idMatiere);
			}

			function AjouterReponseAQuestion()
			{
				var libelleReponse = document.getElementById('input_text_nouvelle_reponse').value;
				var valide;
				var idQuestion = GetSelectedRowID('table_libelles_questions');

				if (document.getElementById('checkbox_reponse_correcte').checked == true)
					valide = true;
				else
					valide = false;

				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_ajoutReponseAQuestion.php", true);

				xhr.onreadystatechange = function() {
					if ((xhr.readyState == 4) && (xhr.status == 200)) {
						var tableau = document.getElementById('table_libelles_questions');
						var lignesTableau = tableau.getElementsByTagName('tr');
						var i;
						var idRow = -1;

						for (i = 0; i < lignesTableau.length; i++)
						{
							if (lignesTableau[i].style.backgroundColor == "rgb(149, 188, 242)")
								idRow = i;
						}

						ChangerQuestionEnCours(lignesTableau[idRow]);
					}
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("LibelleReponse=" + libelleReponse + "&Valide=" + valide + "&IdQuestion=" + idQuestion);

			}

			function GetSelectedRowID(idTableau)
			{
				var tableau = document.getElementById(idTableau);
				var lignesTableau = tableau.getElementsByTagName('tr');
				var i;
				var idRow = -1;

				for (i = 0; i < lignesTableau.length; i++)
				{
					if (lignesTableau[i].style.backgroundColor == "rgb(149, 188, 242)")
						idRow = lignesTableau[i].id;
				}

				return idRow;
			}

			function TEST()
			{
				var id = GetSelectedRowID('table_libelles_quiz');
			}

			function ModifierValiditeReponse(checkbox)
			{
				var idReponse = checkbox.id;
				var valide;

				if (checkbox.checked)
					valide = true;
				else
					valide = false;

				var xhr = new XMLHttpRequest();

				xhr.open("POST", "xhr_modifierValiditeReponse.php", true);

				xhr.onreadystatechange = function() {
					if ((xhr.readyState == 4) && (xhr.status == 200)) {
						var tableau = document.getElementById('table_libelles_questions');
						var lignesTableau = tableau.getElementsByTagName('tr');
						var i;
						var idRow = -1;

						for (i = 0; i < lignesTableau.length; i++)
						{
							if (lignesTableau[i].style.backgroundColor == "rgb(149, 188, 242)")
								idRow = i;
						}

						ChangerQuestionEnCours(lignesTableau[idRow]);
					}
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("Valide=" + valide + "&IdReponse=" + idReponse);
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

				echo "<div name='div_entete' style='width: 100%;'>";
				echo "<div style='display: inline-block; float: left;'>";
				echo "<h2 style='display: inline-table; vertical-align: middle;' >Mes Matières :</h2>";
				echo "</div>";
				echo "<div style='display: inline-block; float: left;'>";
				echo "<div style='display: inline-table;' class='radioButtons'>";
				echo "<span><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_".$libelleMatiere."' name='radios_matieres' value='".$idMatiere."' checked='true'/>";
				echo "<label for='radio_".$libelleMatiere."'>".$libelleMatiere."</label></span>";

				while ($row = pg_fetch_array($result))
				{
					$libelleMatiere = $row["libellematiere"];
					$idMatiere2 = $row["idmatiere"];

					echo "<span class='rightRadioButton'><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_".$libelleMatiere."' name='radios_matieres' value='".$idMatiere2."' />";
					echo "<label for='radio_".$libelleMatiere."'>".$libelleMatiere."</label></span>";
				}
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_questions_dans_matiere($idMatiere));

				echo "<div name='div_questions_centre' style='width: 100%; clear: both'>";
				echo "<table style='width: 100%;' class = 'TestScrollable' id = 'table_libelles_questions'>";
				echo "<thead><th style='min-width: 600px; width: 600px'>Question</th><th class='thAuto' style='min-width: 150px; width: 150px'>Mots clés</th><th class='thAuto'>Temps total</th></thead>";
				echo "<tbody style='width: 100%'>";

				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequestion"];
					$idQuestion = $row["idquestion"];
					$tempsquestion = $row["tempsquestion"];
					$motscles = $row["motscles"];
					echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuestionEnCours(this)' id = '$idQuestion'><td style='min-width: 600px; width: 600px'>$libelle</td>";
					echo "<td class='tdAuto' style='width: 150px; min-width: 150px; max-width: 150px''>$motscles</td>";
					echo "<td class='tdAuto'>$tempsquestion</td></tr>";
				}

				echo "</tbody>";
				echo "</table>";
			}

			echo "<form>";
			echo "<label for='input_text_nouvelle_question'>Nom de la question :</label>";
			echo "<input id='input_text_nouvelle_question' type='text' value = '' name='nomQuestion'><br>";
			echo "<label for='input_text_temps_nouvelle_question'>Temps total :</label>";
			echo "<input id='input_text_temps_nouvelle_question' type='text' value = '' name='tempsQuestion'><br>";
			echo "<label for='input_text_mots_cles_nouvelle_question'>Mots clés :</label>";
			echo "<input id='input_text_mots_cles_nouvelle_question' type='text' value = '' name='motsCles'><br>";
			echo "<input onClick='AjouterQuestionAMatiere()' class ='boutonPetit' type='button' value = 'Ajouter question'>";
			echo "</form>";
			echo "</div>";

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_reponses_dans_question(1));

				echo "<div name='div_reponses_centre' style='clear: both; width: 50%;'>";
				echo "<table class ='TestScrollable' style='width: 500px;' id = 'table_libelles_reponses_questions'>";
				echo "<thead><th style='min-width: 400px; width: 400px'>Réponse</th><th class='thAuto'>Correcte?</th></thead>";
				echo "<tbody style='width: 100%'>";
				echo "</tbody>";
				echo "</table>";
			}

			echo "<form>";
			echo "<label for='input_text_nouvelle_reponse'>Nom de la reponse</label>";
			echo "<input type='text' id='input_text_nouvelle_reponse' value = '' name='nomReponse'>";
			echo "<input id='checkbox_reponse_correcte' type='checkbox' name='validite2' value = 'Retirer Question'>Correcte ?</input>";
			echo "<input onClick='AjouterReponseAQuestion()' class='boutonPetit' type='button' value = 'Ajouter Reponse'>";
			echo "</form>";
			echo "</div>";
			?>   

        </div>
    </body>
</html>
