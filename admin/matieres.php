<!doctype html>

<html>
    <head>
        <title>Gestion des Compte</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div id="page">
            <?php
            session_start();
            include '../accueil/menu.php';
            include '../bdd/connexionBDD.php';
            include '../bdd/requetes.php';
			if ((!isset($_SESSION["id"])) || (!($_SESSION["statut"] == "admin"))) {
				header('Location:../index.php');
			} else {
				$idAdmin = $_SESSION["id"];

				$dbcon = connexionBDD();

				if (!$dbcon) {
					echo "connection BDD failed<br>";
				} else {
					
					echo "<div name='div_colonne_gauche' style='float:left; width: 48%;'>";
				echo "<table style='width: 100%;' class = 'liste' id = 'table_matiere'>";
				echo "<thead style='width: 100%;'><th>Matière</th><th>Supprimer</th></thead>";
				echo "<tbody style='width: 100%;' >";
				
				$result = pg_query($dbcon,requete_matieres());
				while ($row=pg_fetch_array($result)) {
					echo "<tr>
							<td>" . $row['libellematiere'] . " </td>
							<td> <input type='checkbox' value='".$row['idmatiere']."'> </td>
						</tr>";
				}
				
				echo "</tbody>";
				echo "</table>";
				
				echo "<form action='trait_ajoutNouveauQuiz.php' method='POST'>";
			echo "<label style='width: 40%;' for='input_text_nouveau_quiz'>Matière</label>";
			echo "<input style='width: 50%;' type='text' value = 'Ex:\"SQL\"' name='nomMatiere'><br>";
			echo "<input type='submit' value = 'Ajout Matière'>";
			echo "</form>";
			echo "</div>";
			
			echo "<div name='div_colonne_droite' style='float:right; width: 50%;'>";
				echo "<table style='width: 100%;' class = 'liste listeScrollable' id = 'table_profs'>";
				echo "<thead><th>Nom Prénom</th></thead>";
				//echo "<tbody>";
				$result = pg_query($dbcon,requete_tous_idadminprof_nomadminprof_prenomadminprof());
				while ($row=pg_fetch_array($result)) {
					echo "<tr>
							<td id='".$row['idadminprof']."' style='width: 357px'>" . $row['nomadminprof'] ." ".$row['prenomadminprof']. " </td>							
						</tr>";
				}

				
				//echo "</tbody>";
				echo "</table>";
				
				echo "<select style='width: 100%;' id='select_questions_matiere'>";

				$result = pg_query($dbcon,requete_tous_idadminprof_nomadminprof_prenomadminprof());
				while ($row=pg_fetch_array($result)) {
					echo "<option id = '".$row['idadminprof']."' name='prof'>" . $row['nomadminprof'] ." ".$row['prenomadminprof']. "</option>";
				}
					
				
				echo "</select>";

				echo "<form method='POST' action='trait_ajoutNouvelleQuestion.php'>";
				echo "<input onClick='AjouterProf' type='button' value = 'Associer Professeur'>";
				echo "<input onClick='SupprimerProf()' type='button' value = 'Dissocier Professeur'>";
				
				echo "</form>";
				echo "</div>";
				echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<input class='boutonCenter' style='margin-top=5%' type='submit' value = 'Dissocier Professeur'>";
            }
			}
            ?>
        </div>
    </body>
    