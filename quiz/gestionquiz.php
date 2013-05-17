<!DOCTYPE HTML>
<html lang="fr">
<head>
<meta charset="utf-8" />
<title>Gestion des Quiz</title>
<link rel="stylesheet" href="../styles/theme.css" />
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

  <link rel="stylesheet" href="../styles/theme.css"/>

</head>
<body>
<div id='page'>
    
    
    




    
    
<?php

session_start();
include '../accueil/menu.php';
include '../admin/secret.php';

$dbcon=pg_connect("host=$host user=$login password=$password");

if(!$dbcon){
 echo "connection BDD failed<br>";
}
else
    {
	echo "connection BDD succes <br>";

	$result= pg_query($dbcon, "SELECT libellequestion, tempsquestion
                                        FROM questions, matieres
                                        WHERE questions.idmatiere = matieres.idmatiere
                                        AND matieres.idmatiere = 1;");

        echo "<select name='liste_questions'>";
        
        while($row = pg_fetch_array($result)){
            $libelle=$row["libellequestion"];
            echo "<option>$libelle</option>";
        }
        echo "</select>";
    }

if(!$dbcon){
    echo "connection BDD failed<br>";
}
else
    {
	echo "connection BDD succes <br>";

	$result= pg_query($dbcon, "SELECT DISTINCT Quiz.libelleQuiz, Quiz.idQuiz
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
                        alert(this.rowIndex + 1);
                    }
                }
                }
                </script>";
        
        echo "<table id='table_libelles_quiz'>";
        echo "<tbody>";
   
        while($row = pg_fetch_array($result)){
            $libelle=$row["libellequiz"];
            echo "<tr><td>$libelle</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    
echo "<form action ='../session/publication.php' method='POST'>";
echo "<input class='bouton' type='submit' value='Publier'>";
echo "</form>";

?>   
    
</div>
</body>
</html>
