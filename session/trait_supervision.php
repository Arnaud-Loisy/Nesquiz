<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Traitement publication</title>
                <link rel="stylesheet" href="../styles/theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
    <body>
        <div id='page'>
            <?php

                session_start();
                if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
                    header('Location:../index.php');
                }
                 if((!(isset($_SESSION["idquiz"]))) || (!(isset($_SESSION["dateSession"]))) ||  (!(isset($_SESSION["mode"]))) ){
                header('Location: sdqsdqsdqd.php');
                 }
                 // connexion à la BD
                include '../admin/secret.php';
                $dbcon = pg_connect("host=$host user=$login password=$password");
                
                $_SESSION["etatSession"]=2;
                $modeFonctionnement=$_SESSION["mode"];
                $dateSession=$_SESSION["dateSession"];
                $etatsession=$_SESSION["etatSession"];
                
                
                
                // Mettre le champs etatSession à 2
                
                 $request = "UPDATE Sessions
                            SET etatSession='2'
                            WHERE dateSession='".$dateSession."';";

                $result=pg_query($dbcon,$request) or die("Echec de la requête");
                
                header('Location:supervision.php');
           ?>
                

        </div>
</body>
</html>