<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href="..\styles\theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Accueil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div id="page">
    <?php
    session_start();
    include '../accueil/menu.php';
    if($_SESSION["erreur_log"]===1){
        echo"Erreur de connexion";
    }
  
    
    
    ?>
    <div id="page">
        
   
<form action='traitement.php' method='POST'>
	Login : <input name="login" type="text" ><br>
	Password : <input name="mdp" type ="password"><br>
	<input class="bouton" value="Connexion" type="submit"> 
    </div>
</body>
<html>