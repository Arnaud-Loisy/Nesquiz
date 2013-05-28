<!doctype html>

<html>
    <head>
        <title>Gestion des Compte</title>
        <link rel="stylesheet" href="../styles/theme.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <script>
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
        var idQuizEnCours = -1;

			function ChangerProfs(ligneTableau)
			{
				//var value = oSelect.options[oSelect.selectedIndex].value;	²	
				idQuizEnCours = ligneTableau.id;
				var value = ligneTableau.id;
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "xhr_matiere.php", true);

				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && (xhr.status == 200)) {
						document.getElementById('table_profs').innerHTML = xhr.responseText;
						//document.getElementById("loader").style.display = "none";
					} /*else if (xhr.readyState < 4) {
					 document.getElementById("loader").style.display = "inline";
					 }*/
				};

				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("idMatiere=" + value);
				
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
			function AssocierProf(){
				var idMatiere = GetSelectedRowID('table_matiere');
				var idAdminProf = getSelectValue("select_questions_matiere")
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "matieres_traitement.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("associe=1&idMatiere=" + idMatiere + "&idAdminProf=" + idAdminProf);
				
				var xhr2 = new XMLHttpRequest();
				xhr2.open("POST", "xhr_matiere.php", true);xhr2.onreadystatechange = function() {
					if (xhr2.readyState == 4 && (xhr2.status == 200)) {
						document.getElementById('table_profs').innerHTML = xhr2.responseText;
						
					} 
				};

				xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr2.send("idMatiere=" + idMatiere);
				
			}
			function DissocierProf(){
				var idMatiere = GetSelectedRowID('table_matiere');
				var idAdminProf = getSelectValue("select_questions_matiere")
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "matieres_traitement.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("dissocie=1&idMatiere=" + idMatiere + "&idAdminProf=" + idAdminProf);
				
				var xhr2 = new XMLHttpRequest();
				xhr2.open("POST", "xhr_matiere.php", true);xhr2.onreadystatechange = function() {
					if (xhr2.readyState == 4 && (xhr2.status == 200)) {
						document.getElementById('table_profs').innerHTML = xhr2.responseText;
						
					} 
				};

				xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr2.send("idMatiere=" + idMatiere);
				
			}
			function getSelectValue(selectId)
{
	/**On récupère l'élement html <select>*/
	var selectElmt = document.getElementById(selectId);
	/**
	selectElmt.options correspond au tableau des balises <option> du select
	selectElmt.selectedIndex correspond à l'index du tableau options qui est actuellement sélectionné
	*/
	return selectElmt.options[selectElmt.selectedIndex].value;
}
			
        </script>
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
				/*echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<input class='boutonCenter' style='margin-top=5%' type='submit' value = 'Appliquer changements'>";*/
            }
			}
            ?>
        </div>
    </body>
    