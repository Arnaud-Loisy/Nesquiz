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

			var last_radioButton = -1;

			function InvertColorOfRadioButton(radioButton)
			{
				//alert(tableRow.textContent);
				//alert(tableRow.id);
				if (last_radioButton !== -1)
				{
					last_radioButton.style.backgroundColor = "rgb(255, 255, 255)";
				}
				if (radioButton.style.backgroundColor !== "rgb(149,188,242)") {
					radioButton.style.backgroundColor = "rgb(149,188,242)";
				}
				else
				{
					radioButton.style.backgroundColor = "rgb(255, 255, 255)";
				}
				last_radioButton = radioButton;
			}

        </script>

    </head>


    <body>

        <div id='page'>

			<?php
			session_start();
			include '../accueil/menu.php';
			include '../admin/secret.php';
			
			echo "<br>Mes matières : <div class='radioButtons'>
					<span><input type='radio' id='radio_php'  name='radios' value='php' />
					<label for='radio_php'>php</label></span>
					<span class='rightRadioButton'><input type='radio' id='radio_css' name='radios' value='css' />
					<label for='radio_css'>css</label></span>
				</div><br><br><br><br><br><br>";

			$dbcon = pg_connect("host=$host user=$login password=$password");

			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, "SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
                                    FROM Quiz, Inclu, Questions, Matieres
                                    WHERE Quiz.idQuiz = Inclu.idQuiz
                                    AND Questions.idQuestion = Inclu.idQuestion
                                    AND Questions.idMatiere = Matieres.idMatiere
                                    AND Matieres.idMatiere = 1;");

				echo "<script type='text/javascript'>
                onload = function() {
                if (!document.getElementsByTagName || !document.createTextNode) return;
                var rows = document.getElementById('table_libelles_quiz').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (i = 0; i < rows.length; i++) {
                    rows[i].onclick = function() {
                        alert(this.rowIndex());
                    }
                }
                }
                </script>";

				echo "<table class='tableau_mystique' id='table_libelles_quiz'>";
				echo "<tbody>";
				echo "<th>Nom du quiz</th>";

				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequiz"];
					$idQuiz = $row["idquiz"];
					echo "<tr onclick='InvertColorOfTableLine(this)' id='$idQuiz'><td>$libelle</td></tr>";
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
				$result = pg_query($dbcon, "SELECT libelleQuestion, Questions.idQuestion
                                    FROM Quiz, Questions, Inclu
                                    WHERE Quiz.idQuiz = Inclu.idQuiz
                                    AND Questions.idQuestion = Inclu.idQuestion
                                    AND Quiz.idQuiz = 1");

				echo "<script type='text/javascript'>
                onload = function() {
                if (!document.getElementsByTagName || !document.createTextNode) return;
                var rows = document.getElementById('table_libelles_questions_quiz').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                for (i = 0; i < rows.length; i++) {
                    rows[i].onclick = function() {
                        alert(this.rowIndex());
                    }
                }
                }
                </script>";
        
        echo "<table id='table_libelles_questions_quiz'>";
        echo "<tbody>";
        echo "<th>Questions présentes</th>";
   
        $i = 1;
        while($row = pg_fetch_array($result)){
            $libelle=$row["libellequestion"];
            /*echo "<tr><td onclick='SelectRow(".$i.", 2)' id='cell_".$i.",1'>$libelle</td></tr>";*/
            echo "<tr><td onclick='InvertColorOfTableLine(this)'>$libelle</td></tr>";
            $i++;
        }
        echo "</tbody>";
        echo "</table>";
    }    
    
echo "<form action ='../session/publication.php' method='POST'>";
echo "<input class='boutonCenter' type='submit' value='Publier'>";
echo "</form>";

				echo "<table class='tableau_mystique' id='table_libelles_questions_quiz'>";
				echo "<tbody>";
				echo "<th>Questions présentes</th>";

				$i = 1;
				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequestion"];
					$idQuestion = $row["idquestion"];
					/* echo "<tr><td onclick='SelectRow(".$i.", 2)' id='cell_".$i.",1'>$libelle</td></tr>"; */
					echo "<tr><td onclick='InvertColorOfTableLine(this)' id='$idQuestion'>$libelle</td></tr>";
					$i++;
				}
				echo "</tbody>";
				echo "</table>";
			}

			echo "<form action ='../session/publication.php' method='POST'>";
			echo "<input class='bouton' type='submit' value='Publier'>";
			echo "</form>";
			
			if (!$dbcon)
			{
				echo "connection BDD failed<br>";
			}
			else
			{
				$result = pg_query($dbcon, "SELECT libellequestion, tempsquestion, idquestion
                                        FROM questions, matieres
                                        WHERE questions.idmatiere = matieres.idmatiere
                                        AND matieres.idmatiere = 1;");

				echo "<select name='liste_questions'>";

				while ($row = pg_fetch_array($result))
				{
					$libelle = $row["libellequestion"];
					$idQuestion = $row["idquestion"];
					echo "<option id='$idQuestion'>$libelle</option>";
				}
				echo "</select>";
			}
			
			?>   

        </div>
    </body>
</html>
