<!doctype html>

<html>
    
<head>
     <link rel="stylesheet" href=".\styles\theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Accueil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <div id="page">
    <?php
    session_start();
    include './accueil/menu.php';
    if(isset($_SESSION["erreur_log"])){
        echo"Erreur de connexion";
        unset($_SESSION["erreur_log"]);  
       }    
    if (isset($_SESSION["id"])){
      header("Location:accueil/accueil.php");
    }
    ?>
   
        
   <br>
        <br>
<form action='accueil/traitement.php' method='POST'>
	Login : <input name="login" type="text" ><br>
	Password : <input name="mdp" type ="password"><br>
	<input class="bouton" value="Connexion" type="submit"> 
    </div>
</body>
<html>