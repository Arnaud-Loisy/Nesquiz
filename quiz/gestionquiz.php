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

echo"<form action ='/session/publication.php' method='POST'>";
echo "<input class='bouton' type='submit' value='Publier'>";
echo "</form>";

?>
</div>
</body>
</html>