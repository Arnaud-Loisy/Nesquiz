<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Gestion des Quiz</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <script type='text/javascript'>

			/** Fonction qui permet d'inverser la couleur d'une ligne d'un tableau
			 * 
			 * @param Ligne d'un tableau tableRow
			 * @returns Rien
			 */
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

			/** Fonction qui permet de changer la matiere en cours sur la page
			 * 
			 * @param Bouton Radio radioButton
			 * @returns Rien
			 */
			function ChangerMatiereEnCours(radioButton)
			{
				var value = radioButton.value; // On recupere l'id de la matiere

				//
				// Modification de la liste des questions de la matiere
				//
				var xhr = new XMLHttpRequest(); // Creation d'une variable de requete HttpRequest
				xhr.open("POST", "xhr_getListeQuestions.php", true); // Page qui sera appelée sur le serveur

				xhr.onreadystatechange = function() { // Quand le statut de xhr change
					if (xhr.readyState == 4 && (xhr.status == 200)) { // Lorsque la requête est bien passée
						document.getElementById('select_questions_matiere').innerHTML = xhr.responseText;
						// On modifie le contenu de 'select_questions_matiere' avec le retour de la requete
					}
				};

				// En-tete http
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				// Variable IdMatiere envoyee en POST à la page + Envoi de la requete
				xhr.send("IdMatiere=" + value);

				//
				//Modification de la liste des quiz de cette matiere
				//
				var xhr2 = new XMLHttpRequest();
				xhr2.open("POST", "xhr_getListeQuizParMatiere.php", true);

				xhr2.onreadystatechange = function() {
					if (xhr2.readyState == 4 && (xhr2.status == 200)) {
						document.getElementById('table_libelles_quiz').innerHTML = xhr2.responseText;
					}
				};
				xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr2.send("IdMatiere=" + value);

				//
				//Modification de la liste des questions dans un quiz donne
				//
				document.getElementById('table_libelles_questions_quiz').innerHTML = "<table class ='TestScrollable' style='width: 400px;' id = 'table_libelles_questions_quiz'>\
																						<thead><th style='width:  400px'>Questions présentes</th></thead><tbody></tbody></table>";
			}

			var idQuizEnCours = -1;

			/** Fonction permettant de changer le quiz selectionne sur la page
			 * 
			 * @param Ligne d'un tableau ligneTableau
			 * @returns Rien
			 */
			function ChangerQuizEnCours(ligneTableau)
			{
				idQuizEnCours = ligneTableau.id;
				var value = ligneTableau.id;
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "xhr_getListeQuestionsParQuiz.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200)) {
						document.getElementById('table_libelles_questions_quiz').innerHTML = xhr.responseText;
					}
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("IdQuiz=" + value);
			}

			/** Fonction permettant d'ajouter une question à un quiz
			 * 
			 * @returns Rien
			 */
			function AjouterQuestionAQuiz()
			{
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

			/** Fonction permettant de supprimer une question à un quiz
			 * 
			 * @returns Rien
			 */
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

			/** Fonction retournant l'ID de la ligne selectionne dans un tableau cliquable
			 * 
			 * @param ID du tableau idTableau
			 * @returns ID
			 */
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
		</script>

    </head>
    <body>
        <div id='page'>
			<?php
			session_start();
			if (!isset($_SESSION["id"]) || ($_SESSION["statut"] == "etu"))
				header('Location:../index.php');
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

				echo "<div name='div_entete' style='width: 100%; clear: both;'>";
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
					$idMatiere = $row["idmatiere"];

					echo "<span class='rightRadioButton'><input onClick = 'ChangerMatiereEnCours(this)' type ='radio' id='radio_".$libelleMatiere."' name='radios_matieres' value='".$idMatiere."' />";
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
				$result = pg_query($dbcon, requete_tous_quiz_dans_matiere(1));

				echo "<div name='div_colonne_gauche' style='float:left; width: 48%; clear: both;'>";
				echo "<table style='width: 400px;' class = 'TestScrollable' id = 'table_libelles_quiz'>";
				echo "<thead><th class='thFixed'>Nom du quiz</th><th class='thAuto'>Temps total</th></thead>";
				echo "<tbody>";

				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequiz"];
					$idQuiz = $row["idquiz"];
					$tempsquiz = $row["tempsquiz"];
					echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td class='tdFixed'>$libelle</td>";
					echo "<td class='tdAuto'>$tempsquiz</td></tr>";
				}

				$result = pg_query($dbcon, requete_tous_quiz_sans_matiere(1));

				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequiz"];
					$idQuiz = $row["idquiz"];
					$tempsquiz = $row["tempsquiz"];
					echo "<tr onclick = 'InvertColorOfTableLine(this) ; ChangerQuizEnCours(this)' id = '$idQuiz'><td class='tdFixed'><b><i>$libelle</i></b></td>";
					echo "<td class='tdAuto'>$tempsquiz</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			}

			echo "<form action='trait_ajoutNouveauQuiz.php' method='POST'>";
			echo "<label style='width: 90px; display: inline-block' for='input_text_nouveau_quiz'>Nom du quiz</label>";
			echo "<input type='text' value = 'Ex:\"IPV6\"' name='nomQuiz'><br>";
			echo "<label style='width: 90px; display: inline-block'  for='input_text_temps_nouveau_quiz'>Temps total</label>";
			echo "<input type='text' value = 'Ex:\"200(secondes)\"' name='tempsQuiz'><br>";
			echo "<input class ='boutonPetit' type='submit' value = 'Nouveau Quiz'>";
			echo "</form>";
			echo "</div>";

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_questions_dans_quiz(1));

				echo "<div name='div_colonne_droite' style='float:right; width: 50%;'>";
				echo "<table class ='TestScrollable' style='width: 400px;' id = 'table_libelles_questions_quiz'>";
				echo "<thead><th style='width:  400px'>Questions présentes</th></thead>";
				echo "<tbody>";
				echo "</tbody>";
				echo "</table>";
			}

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, requete_toutes_questions_dans_matiere(1));

				echo "<select style='width: 400px;' id='select_questions_matiere'>";

				while ($row = pg_fetch_array($result))
				{
					$libelleQuestion = $row["libellequestion"];
					$idQuestion = $row["idquestion"];
					echo "<option id = '$idQuestion' name='$libelleQuestion'>$libelleQuestion</option>";
				}
				echo "</select>";

				echo "<form method='POST' action='../questions/gestionquestions.php'>";
				echo "<input class='boutonPetit' onClick='AjouterQuestionAQuiz()' type='button' value = 'Ajouter Question'>";
				echo "<input class='boutonPetit' onClick='SupprimerQuestionAQuiz()' type='button' value = 'Retirer Question'>";
				echo "<input class='boutonPetit' type='submit' value = 'Gérer Questions'>";
				echo "</form>";
				echo "</div>";
			}
			?>   
        </div>
    </body>
</html>
