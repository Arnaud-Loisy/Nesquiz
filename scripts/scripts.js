var last_tableRow = -1;

function InvertColorOfTableLine(tableRow) {
	//alert(tableRow.textContent);
	//alert(tableRow.id);
	if (last_tableRow !== -1) {
		last_tableRow.style.backgroundColor = "rgb(255, 255, 255)";
	}
	if (tableRow.style.backgroundColor !== "rgb(149,188,242)") {
		tableRow.style.backgroundColor = "rgb(149,188,242)";
	} else {
		tableRow.style.backgroundColor = "rgb(255, 255, 255)";
	}
	last_tableRow = tableRow;
}

function GetSelectedRowID(idTableau) {
	var tableau = document.getElementById(idTableau);
	var lignesTableau = tableau.getElementsByTagName('tr');
	var i;
	var idRow = -1;

	for ( i = 0; i < lignesTableau.length; i++) {
		if (lignesTableau[i].style.backgroundColor == "rgb(149, 188, 242)")
			idRow = lignesTableau[i].id;
	}

	return idRow;
}

function getSelectValue(selectId) {
	/**On récupère l'élement html <select>*/
	var selectElmt = document.getElementById(selectId);
	/**
	 selectElmt.options correspond au tableau des balises <option> du select
	 selectElmt.selectedIndex correspond à l'index du tableau options qui est actuellement sélectionné
	 */
	return selectElmt.options[selectElmt.selectedIndex].value;
}
function getSelectValueByName() {
	/**On récupère l'élement html <select>*/
	var selectElmt = document.getElementsByName('radios_matieres');
	for(var i=0;i<selectElmt.length; i++){
	  if(selectElmt[i].checked==true){
	  	//alert (selectElmt[i].value);
	  	return selectElmt[i].value;
	  }
	  
	};
	return null;
	
}

function changerStats(radiobtn) {
	var idMatiere = getSelectValueByName();
	var promo = getSelectValue('numPromo');
	var xhr = new XMLHttpRequest();

	xhr.open("POST", "xhr_stats.php", true);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			//alert(xhr.responseText);
			document.getElementById('table_stat').innerHTML = xhr.responseText;
		}
	};

	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("idMatiere=" + idMatiere + "&promo=" + promo);

}

function changerStatsNotes(radiobtn) {
	var idMatiere = radiobtn.value;

	var xhr = new XMLHttpRequest();

	xhr.open("POST", "xhr_notes_detaillees.php", true);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			//alert(xhr.responseText);
			document.getElementById('table_stat').innerHTML = xhr.responseText;
		}
	};

	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("idMatiere=" + idMatiere);

}

function changerStatsToutes(radiobtn) {
	var idMatiere = radiobtn.value;
	var xhr = new XMLHttpRequest();

	xhr.open("POST", "xhr_notes.php", true);

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			//alert(xhr.responseText);
			document.getElementById('table_stat').innerHTML = xhr.responseText;
		}
	};

	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("idMatiere=" + idMatiere);
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

function AssocierProf() {
	var idMatiere = GetSelectedRowID('table_matiere');
	var idAdminProf = getSelectValue("select_questions_matiere")
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "matieres_traitement.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("associe=1&idMatiere=" + idMatiere + "&idAdminProf=" + idAdminProf);

	var xhr2 = new XMLHttpRequest();
	xhr2.open("POST", "xhr_matiere.php", true);
	xhr2.onreadystatechange = function() {
		if (xhr2.readyState == 4 && (xhr2.status == 200)) {
			document.getElementById('table_profs').innerHTML = xhr2.responseText;

		}
	};

	xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr2.send("idMatiere=" + idMatiere);

}

function DissocierProf() {
	var idMatiere = GetSelectedRowID('table_matiere');
	var idAdminProf = getSelectValue("select_questions_matiere")
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "matieres_traitement.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("dissocie=1&idMatiere=" + idMatiere + "&idAdminProf=" + idAdminProf);

	var xhr2 = new XMLHttpRequest();
	xhr2.open("POST", "xhr_matiere.php", true);
	xhr2.onreadystatechange = function() {
		if (xhr2.readyState == 4 && (xhr2.status == 200)) {
			document.getElementById('table_profs').innerHTML = xhr2.responseText;

		}
	};

	xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr2.send("idMatiere=" + idMatiere);

}
