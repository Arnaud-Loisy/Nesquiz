<!DOCTYPE HTML>
<html lang="fr">
<head>
<meta charset="utf-8" />
<title>Liste des quiz en cours</title>
<link rel="stylesheet" href="..\styles\theme.css" />
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
 				echo "connection échouée à la BDD<br>";
			}else
				echo "connection réussie à la BDD<br>";
$requete="SELECT libelleQuiz
	FROM Sessions, Quiz
	WHERE Sessions.idQuiz = Quiz.idQuiz
	AND Sessions.etat=1;";
$result = pg_query($dbcon,$requete);
while($tableauquiz = pg_fetch_array($result)){
	echo $tableauquiz['libellequiz']."<br>";
}

	
?>
</div>
</body>
</html>