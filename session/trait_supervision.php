<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Traitement supervision</title>
                <link rel="stylesheet" href="../styles/theme.css" />
        </head>
    <body>
        <div id='page'>
            <?php

                session_start();
                if(!(isset($_SESSION["id"])) || ($_SESSION["statut"]=="etu")){
                    header('Location:../index.php');
                }
                 if((!(isset($_SESSION["idquiz"]))) || (!(isset($_SESSION["dateSession"]))) ||  (!(isset($_SESSION["mode"]))) ){
                header('Location: publication.php');
                 }
                // connexion à la BD
                include '../bdd/connexionBDD.php';
                include '../bdd/requetes.php';
                $dbcon = connexionBDD();
                 
                $_SESSION["etatSession"]=2;
                $dateSession=$_SESSION["dateSession"];
                
                // Mettre le champs etatSession à 2 dans la BD
                pg_query($dbcon,  requete_changer_etat_session($dateSession, 2)) or die("Echec de la requête");
                
                // rediriger vers supervision
                header('Location:supervision.php');
           ?>
        </div>
</body>
</html>