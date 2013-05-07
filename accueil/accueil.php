<html>
    
<head>
     <link rel="stylesheet" href="..\styles\theme.css" />
    <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>

<title>Accueil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <?php
    session_start();
    include '../accueil/menu.php';
    echo"Bonjour".$_SESSION['prenom'].$_SESSION['nom'];
    
    ?>
    <div id="page">
        
    </div>

</body>
<html>