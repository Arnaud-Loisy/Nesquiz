<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Supervision d'une session</title>
                <link rel="stylesheet" href="..\styles\theme.css" />
		<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" type="text/css"/>
        </head>
<body>
    <div id='page'>
        <?php
            http://www.nesquiz.fr/session/supervision.php?idquiz=1&mode=2&mdpSession=dfdf
            session_start();
            if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
                header('Location:../index.php');
            }
            if(!(isset($_GET["mode"])) || !(isset($_GET["idquiz"]))){
                header('Location:publication.php');
            }
            
            // Récup des variables
            $dateSession= 1;//time()+6*3600;
            $modeFonctionnement=$_GET["mode"];
            $mdpSession=$_GET["mdpSession"];
            $idquiz=$_GET["idquiz"];
            $etatsession=1;
            
            // transmission des variables utiles à la page "supervision.php"
            $_SESSION["datesession"]=$dateSession;
            $_SESSION["idquiz"]=$idquiz;
            $_SESSION["mode"]=$modeFonctionnement;
            $_SESSION["etatsession"]=$etatsession;
            
            // connexion à la BD
            include '../admin/secret.php';
            $dbcon = pg_connect("host=$host user=$login password=$password");
            
            // Créa de la session, en attente des élèves
            $request = "INSERT INTO sessions VALUES ('".time()."','".$modeFonctionnement."','".$mdpSession."','".$idquiz."','".$etatsession."');";
            pg_query($dbcon,$request) or die("Echec de la requête");
            
            header("Location: supervision.php");
            
            ?>
        
    </div>
</body>
</html>