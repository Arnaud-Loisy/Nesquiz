<html>
    
<head>
     <link rel="stylesheet" href="../styles/theme.css" />

<title>Accueil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
       <div id="page">
        
 

    <?php
    session_start();
    include '../accueil/menu.php';
    echo"<br><h1> Bonjour ".$_SESSION["prenom"]." ".$_SESSION["nom"]."</h1>";
    
    ?>
      </div>

</body>
<html>