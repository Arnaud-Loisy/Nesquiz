<!DOCTYPE HTML>
<html lang="fr">
<head>
<meta charset="utf-8" />
<title>Gestion des Quiz</title>
<link rel="stylesheet" href="../styles/theme.css" />
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<link rel="stylesheet" href="../styles/theme.css"/>
  
<style>
/*body { width: 500px; text-align: center; font: bold 10px/16px Verdana, sans-serif; color: #555; margin: 20px auto; }*/
/*h1, p { text-align: left; font-weight: normal; }*/
/*h1 { font: bold 14px "Trebuchet MS", sans-serif; color: #600; }*/
/*table { width: 500px; margin: 0 auto; font-size: 12px; border: 1px solid #ccc; border-width: 1px 0 0 1px; border-collapse: collapse; }*/
/*caption { margin: 0 auto; font-size: 12px; margin-bottom: 2em; }*/
/*td { padding: 10px; border: 1px solid #ccc; border-width: 0 1px 1px 0; }*/
/*tr:hover td { background: #CAEFFD; color: #0768B3; cursor: pointer; }*/
</style>



<script type='text/javascript'>

var currentRow=-1;

function SelectRow(newRow, maxColLength)
{
   for(var i=1;i<maxColLength;++i)
   {
       var cell=document.getElementById('cell_'+newRow+','+i);
       cell.style.background='#AAF';

       if(currentRow !== -1)
       {
           var cell=document.getElementById('cell_'+currentRow+','+i);
           cell.style.background='#FFF';
       }
   }
   currentRow=newRow;
}

function IsSelected()
{
   return currentRow === -1 ? false:true;
}

function GetSelectedRow()
{
   return currentRow;
}

function ChangeColor(tableRow, highLight)
{
               if (highLight){
            	   tableRow.style.backgroundColor = '00CCCC';
               }
            
            else{
            	 tableRow.style.backgroundColor = 'white';
                }
}
                
</script>

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
                        alert(this.rowIndex());
                    }
                }
                }
                </script>";
        
        echo "<table id='table_libelles_quiz'>";
        echo "<tbody>";
        echo "<th>Nom du quiz</th>";
   
        while($row = pg_fetch_array($result)){
            $libelle=$row["libellequiz"];
            echo "<tr><td onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)'>$libelle</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    
if(!$dbcon){
    echo "connection BDD failed<br>";
}
else
    {
	echo "connection BDD succes <br>";

	$result= pg_query($dbcon, "SELECT libelleQuestion, Questions.idQuestion
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
            echo "<tr><td onclick='SelectRow(".$i.", 2)' id='cell_".$i.",1'>$libelle</td></tr>";
            $i++;
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
