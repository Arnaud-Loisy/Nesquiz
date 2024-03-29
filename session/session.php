<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=830">
		<title>Session</title>
		<link rel="stylesheet" href="../styles/theme.css" />
	</head>
	<body>
		<div id='page'>
			<?php
			session_start();
			if (!isset($_SESSION["id"]) || (!isset($_SESSION['idSession']))) {
				header('Location:../index.php');
			}

			include '../accueil/menu.php';
			include '../bdd/connexionBDD.php';
			include '../bdd/requetes.php';
			$dateSession = $_SESSION['idSession'];
			$id = $_SESSION['id'];
			
			//DEBUG
			//var_dump($_POST);
			//var_dump($_SESSION);
			if (isset($_POST['precedent'])) {
				if ($_SESSION['Curseur'] > 1)
					$_SESSION['Curseur']--;
				unset($_POST['precedent']);
				
				echo '<br><center><div id="compte_a_rebours"></div></center>';
					$compte_a_rebours = '<script type="text/javascript">
					function compte_a_rebours()
					{
						var compte_a_rebours = document.getElementById("compte_a_rebours");
		
						var date_actuelle = new Date();
						var date_evenement = ' . $_SESSION['fin'] * 1000 . '
						var total_secondes = (date_evenement - date_actuelle) / 1000;
		
						var prefixe = "Temps restant <br>";
						if (total_secondes < 0)
					{
							prefixe = "Temps écoulé."; // On modifie le préfixe si la différence est négatif
		
							total_secondes = 0; // 
		
					}
		
						if (total_secondes > 0)
						{
							var jours = Math.floor(total_secondes / (60 * 60 * 24));
							var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
							minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
							secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));
		
							var et = "et";
							var mot_jour = "jours<br>";
							var mot_heure = "heures<br>";
							var mot_minute = "minutes<br>";
							var mot_seconde = "secondes";
		
							if (jours == 0)
							{
								jours = "";
								mot_jour = "";
							}
								else if (jours == 1)
							{
								mot_jour = "jour<br>";
							}
		
							if (heures == 0)
							{
								heures = "";
								mot_heure = "";
							}
							else if (heures == 1)
							{
								mot_heure = "heure<br>";
							}
		
							if (minutes == 0)
							{
								minutes = "";
								mot_minute = "";
							}
							else if (minutes == 1)
							{
								mot_minute = "minute<br>";
							}
					
							if (secondes == 0)
							{
								secondes = "";
								mot_seconde = "";
								et = "";
							}
							else if (secondes == 1)
							{
								mot_seconde = "seconde";
							}
					
							if (minutes == 0 && heures == 0 && jours == 0)
							{
								et = "";
							}
					
							compte_a_rebours.innerHTML = prefixe + jours + " " + mot_jour + " " + heures + " " + mot_heure + " " + minutes + " " + mot_minute + " " + et + " " + secondes + " " + mot_seconde;
						}
						else
						{
							compte_a_rebours.innerHTML = "Temps écoulé.";
						}
					
						var actualisation = setTimeout("compte_a_rebours();", 1000);
					}
					compte_a_rebours();
					</script>';
					echo($compte_a_rebours);

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

					echo '<form method="post" action="session.php">
					<h1 class="question">' . $question . ' ? :</h1>
					<input type="hidden" name="Question" value="' . $idQuestion . '"/>';

					$result = pg_query($dbcon, requete_reponses_d_une_question_d_une_session($dateSession, $idQuestion));
					$i = 0;
					while ($array = pg_fetch_array($result)) {

						$reponse = $array['libellereponse'];
						$idreponse = $array['idreponse'];

						//echo '<input type="checkbox" name="' . $i . '" value="' . $idreponse . '"/>' . $reponse . '<br>';
						echo '<span class="checkB"><input type="checkbox" id="' . $i . '"  name="' . $i . '" value=' . $idreponse . ' />
					<label for="' . $i . '">' . $reponse . '</label></span><br>';

						$i++;

					}

				}

			} elseif (isset($_POST['suivant'])) {
				$_SESSION['Curseur']++;
				$SQLQuestion = $_POST['Question'];
				unset($_POST['Question']);
				unset($_POST['suivant']);
				
				
				
				$dbcon = connexionBDD();
				if (!$dbcon) {
					echo "La connexion à la base de donnée a été perdue<br>";
				} else {
					$result = pg_query($dbcon, requete_mdp_etat_session($dateSession));
					$row = pg_fetch_array($result);
					$etatSession = $row['etatsession'];
				}
				if (($_SESSION['NbdeQuestions'] + 1 > $_SESSION['Curseur']) && ($_SESSION['fin'] - time() > 0) && ($etatSession == 2)) {

					// j'ai cliqué sur « Suivant »
					$dbcon = connexionBDD();
					echo '<br><center><div id="compte_a_rebours"></div></center>';
					$compte_a_rebours = '<script type="text/javascript">
					function compte_a_rebours()
					{
						var compte_a_rebours = document.getElementById("compte_a_rebours");
		
						var date_actuelle = new Date();
						var date_evenement = ' . $_SESSION['fin'] * 1000 . '
						var total_secondes = (date_evenement - date_actuelle) / 1000;
		
						var prefixe = "Temps restant <br>";
						if (total_secondes < 0)
					{
							prefixe = "Temps écoulé."; // On modifie le préfixe si la différence est négatif
		
							total_secondes = 0; // 
		
					}
		
						if (total_secondes > 0)
						{
							var jours = Math.floor(total_secondes / (60 * 60 * 24));
							var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
							minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
							secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));
		
							var et = "et";
							var mot_jour = "jours<br>";
							var mot_heure = "heures<br>";
							var mot_minute = "minutes<br>";
							var mot_seconde = "secondes";
		
							if (jours == 0)
							{
								jours = "";
								mot_jour = "";
							}
								else if (jours == 1)
							{
								mot_jour = "jour<br>";
							}
		
							if (heures == 0)
							{
								heures = "";
								mot_heure = "";
							}
							else if (heures == 1)
							{
								mot_heure = "heure<br>";
							}
		
							if (minutes == 0)
							{
								minutes = "";
								mot_minute = "";
							}
							else if (minutes == 1)
							{
								mot_minute = "minute<br>";
							}
					
							if (secondes == 0)
							{
								secondes = "";
								mot_seconde = "";
								et = "";
							}
							else if (secondes == 1)
							{
								mot_seconde = "seconde";
							}
					
							if (minutes == 0 && heures == 0 && jours == 0)
							{
								et = "";
							}
					
							compte_a_rebours.innerHTML = prefixe + jours + " " + mot_jour + " " + heures + " " + mot_heure + " " + minutes + " " + mot_minute + " " + et + " " + secondes + " " + mot_seconde;
						}
						else
						{
							compte_a_rebours.innerHTML = "Temps écoulé.";
						}
					
						var actualisation = setTimeout("compte_a_rebours();", 1000);
					}
					compte_a_rebours();
					</script>';
					echo($compte_a_rebours);

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

						echo '<form method="post" action="session.php">
						<h1 class="question">' . $question . ' ? :</h1>
						<input type="hidden" name="Question" value="' . $idQuestion . '"/>';

						$result = pg_query($dbcon, requete_reponses_d_une_question_d_une_session($dateSession, $idQuestion));

						$i = 0;
						while ($array = pg_fetch_array($result)) {

							$reponse = $array['libellereponse'];
							$idreponse = $array['idreponse'];

							//echo '<input type="checkbox" name="' . $i . '" value="' . $idreponse . '"/>' . $reponse . '<br>';
							echo '<span class="checkB"><input type="checkbox" id="' . $i . '"  name="' . $i . '" value=' . $idreponse . ' />
					<label for="' . $i . '">' . $reponse . '</label></span><br>';

							$i++;

						}
						$result = pg_query($dbcon, requete_efface_les_reponses_d_une_question_d_une_session_d_un_etudiant($SQLQuestion, $id, $dateSession));
						foreach ($_POST as $key => $SQLreponse) {

							$result = pg_query($dbcon, requete_insertion_des_reponses_choisies($SQLQuestion, $SQLreponse, $id, $dateSession));

						}

					}

				} else {
					$dbcon = connexionBDD();

					if (!$dbcon) {
						echo "La connexion à la base de donnée a été perdue<br>";
					} else {

						if (($_SESSION['fin'] - time() > 0) && ($etatSession == 2)) {

							$result = pg_query($dbcon, requete_efface_les_reponses_d_une_question_d_une_session_d_un_etudiant($SQLQuestion, $id, $dateSession));
							foreach ($_POST as $key => $SQLreponse) {

								$result = pg_query($dbcon, requete_insertion_des_reponses_choisies($SQLQuestion, $SQLreponse, $id, $dateSession));

							}
							unset($_SESSION['fin']);
							unset($_SESSION['debut']);
							header('Location:../session/resultatsSession.php');

						} else {
							unset($_SESSION['fin']);
							unset($_SESSION['debut']);
							header('Location:../session/resultatsSession.php');
						}
					}
				}

			} else {
				// j'arrive sur la page
				$_SESSION['debut'] = time();

				$_SESSION['Curseur'] = 1;
				
				echo '<br><center><div id="compte_a_rebours"></div></center>';
				

				$dbcon = connexionBDD();

				if (!$dbcon) {
					echo "La connexion à la base de donnée a été perdue<br>";
				} else {
					$result = pg_query($dbcon, requete_temps_session($dateSession));
					$array = pg_fetch_array($result) or die("Echec de la requete temp session");
					$tempSession = $array['tempsquiz'];
					$_SESSION['fin'] = $_SESSION['debut'] + $tempSession;
							$compte_a_rebours = '<script type="text/javascript">
					function compte_a_rebours()
					{
						var compte_a_rebours = document.getElementById("compte_a_rebours");
		
						var date_actuelle = new Date();
						var date_evenement = ' . $_SESSION['fin'] * 1000 . '
						var total_secondes = (date_evenement - date_actuelle) / 1000;
		
						var prefixe = "Temps restant <br>";
						if (total_secondes < 0)
					{
							prefixe = "Temps écoulé."; // On modifie le préfixe si la différence est négatif
		
							total_secondes = 0; // 
		
					}
		
						if (total_secondes > 0)
						{
							var jours = Math.floor(total_secondes / (60 * 60 * 24));
							var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
							minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
							secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));
		
							var et = "et";
							var mot_jour = "jours<br>";
							var mot_heure = "heures<br>";
							var mot_minute = "minutes<br>";
							var mot_seconde = "secondes";
		
							if (jours == 0)
							{
								jours = "";
								mot_jour = "";
							}
								else if (jours == 1)
							{
								mot_jour = "jour<br>";
							}
		
							if (heures == 0)
							{
								heures = "";
								mot_heure = "";
							}
							else if (heures == 1)
							{
								mot_heure = "heure<br>";
							}
		
							if (minutes == 0)
							{
								minutes = "";
								mot_minute = "";
							}
							else if (minutes == 1)
							{
								mot_minute = "minute<br>";
							}
					
							if (secondes == 0)
							{
								secondes = "";
								mot_seconde = "";
								et = "";
							}
							else if (secondes == 1)
							{
								mot_seconde = "seconde";
							}
					
							if (minutes == 0 && heures == 0 && jours == 0)
							{
								et = "";
							}
					
							compte_a_rebours.innerHTML = prefixe + jours + " " + mot_jour + " " + heures + " " + mot_heure + " " + minutes + " " + mot_minute + " " + et + " " + secondes + " " + mot_seconde;
						}
						else
						{
							compte_a_rebours.innerHTML = "Temps écoulé.";
						}
					
						var actualisation = setTimeout("compte_a_rebours();", 1000);
					}
					compte_a_rebours();
					</script>';
					echo($compte_a_rebours);
					$result = pg_query($dbcon, requete_nb_de_questions_d_une_session($dateSession));
					$array = pg_fetch_array($result) or die("Echec de la requete7");
					//var_dump($array);

					$_SESSION['NbdeQuestions'] = $array['count'];

					$result = pg_query($dbcon, requete_questions_d_une_session($dateSession));

					$array = pg_fetch_array($result) or die("Echec de la requete1");
					//var_dump($array);
					$question = $array['libellequestion'];
					$idQuestion = $array['idquestion'];

					echo '<form method="post" action="session.php">
					<h1 class="question">' . $question . ' ? :</h1>
					<input type="hidden" name="Question" value="' . $idQuestion . '"/>';

					$result = pg_query($dbcon, requete_reponses_d_une_question_d_une_session($dateSession, $idQuestion));
					$i = 0;
					while ($array = pg_fetch_array($result)) {

						$reponse = $array['libellereponse'];
						$idreponse = $array['idreponse'];

						//echo '<input type="checkbox" name="' . $i . '" value="' . $idreponse . '"/>' . $reponse . '<br>';
						echo '<span class="checkB"><input type="checkbox" id="' . $i . '"  name="' . $i . '" value=' . $idreponse . ' />
					<label for="' . $i . '">' . $reponse . '</label></span><br>';

						$i++;

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

