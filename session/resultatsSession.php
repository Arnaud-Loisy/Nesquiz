<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Résultats de la session</title>
                <link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
        <br> 
        
        
    <?php
      session_start();
      
      if(!(isset($_SESSION["id"])) || !(isset($_SESSION['idSession']))){
        header('Location:../index.php');
      }
      
      include '../accueil/menu.php';
      include '../bdd/connexionBDD.php';
      include 'fonctions_resultats.php';
	  include '../bdd/requetes.php';
      $dbcon = connexionBDD();

     
      // récupérer datesession
      $dateSession = $_SESSION["idSession"];
      unset($_SESSION["idSession"]);
      
          echo("<br><br><br><h1>Vous avez obtenu : ".noteSession($_SESSION["id"],$dateSession)."% de bonnes réponses</h1>");  
      
    ?>
    </div>
</body>

</html>