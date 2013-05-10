<!doctype html>

<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Résultats de la session</title>
                <link rel="stylesheet" href="..\styles\theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
    <?php
    
      session_start();
      if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
        header('Location:../index.php');
      }
      include '../accueil/menu.php';
      include '../admin/secret.php';
    
      
      echo $_POST["idquiz"];
    
    ?>
    </div>
</body>

</html>