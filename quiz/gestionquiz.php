<!DOCTYPE HTML>
<html lang="fr">
<head>
<meta charset="utf-8" />
<title>Gestion des Quiz</title>
<link rel="stylesheet" href="../styles/theme.css" />
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

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
}else
    {
	echo "connection BDD succes <br>";

	$result= pg_query($dbcon, "SELECT libelleQuestion, tempsQuestion
                                        FROM Questions, Matieres
                                        WHERE Questions.idMatiere = Matieres.idMatiere
                                        AND Matieres.idMatiere = 1;");

        echo "<select name='liste_questions'>";
        
        $i=0;
        while($row = pg_fetch_array($result)){
            $libelle=$row["libelleQuestion"];
            echo "$libelle <br>";
            echo "<option>$libelle</option>";
            $i++;
        }
        echo "</select>";
    }

echo"<form action ='/session/publication.php' method='POST'>";
echo "<input class='bouton' type='submit' value='Publier'>";
echo "</form>";

?>
</div>
</body>
</html>