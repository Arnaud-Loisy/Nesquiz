<!doctype html>

<html>
    <head>
        <title>Gestion des Compte</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <script type="text/javascript" src="../scripts/scripts.js"></script>
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
					echo "<form method='POST' action='matieres_traitement.php'>";
				echo "<table style='width: 100%;' class = 'liste' id = 'table_matiere'>";
				echo "<thead style='width: 100%;'><th>Matière</th><th>Supprimer</th></thead>";
				echo "<tbody style='width: 100%;' >";
				
				$result = pg_query($dbcon,requete_matieres());
				while ($row=pg_fetch_array($result)) {
					echo "<tr onClick='InvertColorOfTableLine(this) ; ChangerProfs(this) '  id='".$row['idmatiere']."'>
							<td>" . $row['libellematiere'] . " </td>
							<td> <input type='checkbox' id='".$row['idmatiere']."' name='".$row['idmatiere']."' value='".$row['idmatiere']."'> </td>
						</tr>";
				}
				
				echo "</tbody>";
				echo "</table>";
				
				
			echo "<label style='width: 40%;' for='input_text_nouveau_quiz'>Matière</label>";
			echo "<input style='width: 50%;' type='text' value = 'Ex:\"SQL\"' name='nomMatiere'><br>";
			echo "<input type='submit' class='boutonPetit' name='add' value = 'Ajout Matière'>";
			echo "<input type='submit' class='boutonPetit' name='del' value = 'Supprimer Matière'>";
			echo "</form>";
			echo "</div>";
			
			echo "<div name='div_colonne_droite' style='float:right; width: 50%;'>";
				echo "<table style='width: 100%;' class = 'liste listeScrollable' id = 'table_profs'>";
				echo "<thead style='display: table-header-group;'><th>Nom Prénom</th></thead>";
				echo "<tbody>";
				

				
				echo "</tbody>";
				echo "</table>";
				echo "<form method='POST' action='matieres_traitement.php'>";
				echo "<select name ='idAdminProf' style='width: 100%;' id='select_questions_matiere'>";

				$result = pg_query($dbcon,requete_tous_idadminprof_nomadminprof_prenomadminprof());
				while ($row=pg_fetch_array($result)) {
					echo "<option value = '".$row['idadminprof']."' name='prof'>" . $row['nomadminprof'] ." ".$row['prenomadminprof']. "</option>";
				}
					
				
				echo "</select>";

				
				echo "<input onClick='AssocierProf()' class='boutonPetit' type='button' name='associe' value = 'Associer Professeur'>";
				echo "<input onClick='DissocierProf()' class='boutonPetit' type='button' name='dissocie' value = 'Dissocier Professeur'>";
				
				echo "</form>";
				echo "</div>";
				
            }
			}
            ?>
        </div>
    </body>
    